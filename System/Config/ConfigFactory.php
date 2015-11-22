<?php
namespace SPHERE\System\Config;

use SPHERE\System\Config\Loader\ArrayLoader;
use SPHERE\System\Config\Loader\LoaderInterface;
use SPHERE\System\Config\Reader\IniReader;
use SPHERE\System\Config\Reader\ReaderInterface;
use SPHERE\System\Debugger\DebuggerFactory;
use SPHERE\System\Debugger\Logger\ErrorLogger;

/**
 * Class ConfigFactory
 * @package SPHERE\System\Config
 */
class ConfigFactory implements ConfigInterface
{

    /**
     * @var ReaderInterface
     */
    private static $InstanceCache = array();

    /**
     * @param string $File
     * @param ReaderInterface $Reader
     * @return ReaderInterface
     */
    public function createReader($File, ReaderInterface $Reader = null)
    {
        if (null === $Reader) {
            $Reader = new IniReader();
        }
        $Source = realpath($File);
        if ($Source) {
            if (!$this->isAvailable($Source)) {
                (new DebuggerFactory())->createLogger()->addLog(__METHOD__ . ': ' . $Source);
                $this->setReader($Reader, $Source);
            }
            return $this->getReader($Source);
        } else {
            (new DebuggerFactory())->createLogger(new ErrorLogger())
                ->addLog(__METHOD__ . ' Error: File not available (' . $File . ')');
            return $Reader;
        }
    }

    /**
     * @param mixed $Mixed
     * @param LoaderInterface $Loader
     * @return LoaderInterface
     */
    public function createLoader($Mixed, LoaderInterface $Loader = null)
    {
        if (null === $Loader) {
            $Loader = new ArrayLoader();
        }
            if (!$this->isAvailable($Mixed)) {
                (new DebuggerFactory())->createLogger()->addLog(__METHOD__ . ': ' . json_encode($Mixed));
                $this->setLoader($Loader, $Mixed);
            }
            return $this->getLoader($Mixed);
    }

    /**
     * @param string $File
     * @return bool
     */
    private function isAvailable($File)
    {
        return isset(self::$InstanceCache[$this->getHash($File)]);
    }

    /**
     * @param mixed $Mixed
     * @return string
     */
    private function getHash($Mixed)
    {
        return sha1(serialize($Mixed));
    }

    /**
     * @param ReaderInterface $Reader
     * @param string $File
     */
    private function setReader(ReaderInterface $Reader, $File)
    {
        self::$InstanceCache[$this->getHash($File)] = $Reader->setConfig($File);
    }

    /**
     * @param string $File
     * @return ReaderInterface
     */
    private function getReader($File)
    {
        return self::$InstanceCache[$this->getHash($File)];
    }

    /**
     * @param LoaderInterface $Loader
     * @param mixed $Mixed
     */
    private function setLoader(LoaderInterface $Loader, $Mixed)
    {
        self::$InstanceCache[$this->getHash($Mixed)] = $Loader->setConfig($Mixed);
    }

    /**
     * @param mixed $Mixed
     * @return LoaderInterface
     */
    private function getLoader($Mixed)
    {
        return self::$InstanceCache[$this->getHash($Mixed)];
    }
}
