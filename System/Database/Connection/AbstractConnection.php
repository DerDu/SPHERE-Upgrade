<?php
namespace SPHERE\System\Database\Connection;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use MOC\V\Component\Database\Component\IBridgeInterface;
use MOC\V\Component\Database\Database;
use MOC\V\Core\GlobalsKernel\GlobalsKernel;
use SPHERE\System\Cache\CacheFactory;
use SPHERE\System\Cache\Handler\APCuHandler;
use SPHERE\System\Cache\Handler\MemcachedHandler;
use SPHERE\System\Cache\Handler\MemoryHandler;
use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Config\Reader\ReaderInterface;
use SPHERE\System\Database\Driver\DefaultDriver;
use SPHERE\System\Database\Fitting\Logger;
use SPHERE\System\Debugger\DebuggerFactory;
use SPHERE\System\Debugger\Logger\ErrorLogger;

/**
 * Class AbstractConnection
 *
 * @package SPHERE\System\Database\Connection
 */
abstract class AbstractConnection implements ConnectionInterface
{

    /** @var null|IBridgeInterface $Connection */
    private $Connection = null;

    /**
     * @param string          $Name
     * @param ReaderInterface $Config
     *
     * @return ConnectionInterface
     * @internal param string $Consumer
     */
    public function setConfig($Name, ReaderInterface $Config = null)
    {

        if (null === $this->Connection
            && null !== $Config
            && class_exists('\PDO', false)
        ) {
            $Value = $Config->getValue($Name);
            if ($Value) {
                $Driver = $Value->getValue('Driver');
                $Host = $Value->getValue('Host');
                $Port = $Value->getValue('Port');
                $Timeout = $Value->getValue('Timeout');
                $Username = $Value->getValue('Username');
                $Password = $Value->getValue('Password');
                $Consumer = $Value->getValue('Consumer');

                if ($Driver) {
                    $Driver = $this->fetchDriver($Driver);
                    if (!$Timeout) {
                        $Timeout = 5;
                    }
                    if (!$Port) {
                        $Port = $Driver->getDefaultPort();
                    }
                    if (null === $Consumer) {
                        $Consumer = 'DEMO';
                    }

                    $Database = $this->fetchDatabase($Name, (string)$Consumer);

                    if ($this->openConnection(
                        $Username, $Password, $Database, (string)$Driver, $Host, $Port, $Timeout
                    )
                    ) {

                    } else {
                        (new DebuggerFactory())->createLogger(new ErrorLogger())
                            ->addLog(__METHOD__.' Error: Server not available ('.$Driver->getIdentifier().'@'.$Host.')');
                    }
                } else {
                    (new DebuggerFactory())->createLogger(new ErrorLogger())
                        ->addLog(__METHOD__.' Error: Configuration not available ('.$Value.')');
                }
            } else {
                (new DebuggerFactory())->createLogger(new ErrorLogger())
                    ->addLog(__METHOD__.' Error: Configuration not available ('.$Value.')');
            }
        } else {
            if (null === $Config) {
                (new DebuggerFactory())->createLogger(new ErrorLogger())
                    ->addLog(__METHOD__.' Error: Configuration not available ('.$Name.')');
            }
        }
        return $this;
    }

    private function fetchDriver($Driver)
    {

        $Class = implode('\\', array_slice(explode('\\', __NAMESPACE__), 0, -1)).'\Driver\\'.$Driver.'Driver';
        if (class_exists($Class, true)) {
            return new $Class;
        } else {
            (new DebuggerFactory())->createLogger(new ErrorLogger())
                ->addLog(__METHOD__.' Error: Driver not available ('.$Driver.') -> Fallback ');
            return new DefaultDriver();
        }
    }

    private function fetchDatabase($Name, $Consumer)
    {

        $Database = preg_replace('![^a-z]!is', '', $Name);
        return $Database.( empty( $Consumer ) ? '' : '_'.$Consumer );
    }

    private function openConnection($Username, $Password, $Database, $Driver, $Host, $Port, $Timeout)
    {

        try {
            $this->Connection = Database::getDatabase($Username, $Password, $Database, $Driver, $Host, $Port, $Timeout);
            return true;
        } catch (\Exception $Exception) {
            try {
                Database::getDatabase($Username, $Password, null, $Driver, $Host, $Port, $Timeout)
                    ->getSchemaManager()->createDatabase($Database);
                $this->Connection = Database::getDatabase($Username, $Password, $Database, $Driver, $Host, $Port,
                    $Timeout);
                return true;
            } catch (\Exception $Exception) {
                (new DebuggerFactory())->createLogger(new ErrorLogger())
                    ->addLog(__METHOD__.' Error: Server not available - '.$Exception->getCode().' - '.$Exception->getMessage());
                return false;
            }
        }
    }

    public function createEntityManager($EntityNamespace)
    {

        // Sanitize Namespace
        $EntityNamespace = trim(str_replace(array('/', '\\'), '\\', $EntityNamespace), '\\').'\\';

        // Manager Cache
        $Cache = (new CacheFactory())->createHandler(new MemoryHandler());
        if (null === ( $Manager = $Cache->getValue($EntityNamespace, __METHOD__) )) {

            // Sanitize Path
            $SERVER = GlobalsKernel::getGlobals()->getSERVER();
            $EntityPath = trim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR,
                $SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.trim(str_replace('SPHERE', '', $EntityNamespace), '\\')
            ), DIRECTORY_SEPARATOR
            );

            $MetadataConfiguration = Setup::createAnnotationMetadataConfiguration(array($EntityPath));
            $MetadataConfiguration->setDefaultRepositoryClassName('\SPHERE\System\Database\Fitting\Repository');
            $MetadataConfiguration->addCustomHydrationMode(
                'COLUMN_HYDRATOR', '\SPHERE\System\Database\Fitting\ColumnHydrator'
            );
            $ConnectionConfig = $this->Connection->getConnection()->getConfiguration();

            $CacheFactory = new CacheFactory();
            $MemcachedHandler = $CacheFactory->createHandler(
                new MemcachedHandler(), (new ConfigFactory())->createReader(__DIR__.'/../../Cache.ini')
            );
            $APCuHandler = $CacheFactory->createHandler(new APCuHandler());

            if ($MemcachedHandler instanceof MemcachedHandler) {
                $Memcached = new MemcachedCache();
                $Memcached->setMemcached($MemcachedHandler->getCache());
                $Memcached->setNamespace($EntityPath);
                $ConnectionConfig->setResultCacheImpl($Memcached);
                $MetadataConfiguration->setHydrationCacheImpl($Memcached);
                if ($APCuHandler instanceof APCuHandler) {
                    $MetadataConfiguration->setMetadataCacheImpl(new ApcCache());
                    $MetadataConfiguration->setQueryCacheImpl(new ApcCache());
                } else {
                    $MetadataConfiguration->setMetadataCacheImpl(new ArrayCache());
                    $MetadataConfiguration->setQueryCacheImpl(new ArrayCache());
                }

            } else {
                if ($APCuHandler instanceof APCuHandler) {
                    $MetadataConfiguration->setMetadataCacheImpl(new ApcCache());
                } else {
                    $MetadataConfiguration->setMetadataCacheImpl(new ArrayCache());
                }
                $MetadataConfiguration->setQueryCacheImpl(new ArrayCache());
                $MetadataConfiguration->setHydrationCacheImpl(new ArrayCache());
                $ConnectionConfig->setResultCacheImpl(new ArrayCache());
            }

            $ConnectionConfig->setSQLLogger(new Logger());

            $Manager = EntityManager::create($this->getConnection()->getConnection(), $MetadataConfiguration);
            $Cache->setValue($EntityNamespace, $Manager, 0, __METHOD__);
            (new DebuggerFactory())->createLogger()->addLog(__METHOD__.': Factory '.$EntityNamespace);
        } else {
            (new DebuggerFactory())->createLogger()->addLog(__METHOD__.': Cache '.$EntityNamespace);
        }

        return $Manager;
    }

    /**
     * @return null|IBridgeInterface
     */
    public function getConnection()
    {

        return $this->Connection;
    }
}
