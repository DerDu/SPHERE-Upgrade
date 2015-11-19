<?php
namespace SPHERE\System\Database;

use SPHERE\System\Config\ConfigInterface;
use SPHERE\System\Database\Connection\ConnectionInterface;
use SPHERE\System\Database\Connection\DefaultConnection;
use SPHERE\System\Debugger\DebuggerFactory;

class DatabaseFactory
{
    /**
     * @var ConnectionInterface
     */
    private static $InstanceCache = array();

    /**
     * @param string $Name
     * @param ConfigInterface $Config
     * @param ConnectionInterface $Connection
     * @return ConnectionInterface
     */
    public function createConnection($Name, ConfigInterface $Config = null, ConnectionInterface $Connection = null)
    {
        if (!$this->isAvailable($Name)) {
            if (null === $Connection) {
                $Connection = new DefaultConnection();
            }
            (new DebuggerFactory())->createLogger()->addLog(__METHOD__ . ': ' . $Name);
            $this->setConnection($Name, $Config, $Connection);
        }
        return $this->getConnection($Name);
    }

    /**
     * @param string $Name
     * @return bool
     */
    private function isAvailable($Name)
    {
        return isset(self::$InstanceCache[$this->getHash($Name)]);
    }

    /**
     * @param string $Name
     * @return string
     */
    private function getHash($Name)
    {
        return sha1($Name);
    }

    /**
     * @param string $Name
     * @param ConfigInterface $Config
     * @param ConnectionInterface $Connection
     */
    private function setConnection($Name, ConfigInterface $Config, ConnectionInterface $Connection)
    {
        self::$InstanceCache[$this->getHash($Name)] = $Connection->setConfig($Name, $Config);
    }

    /**
     * @param string $Name
     * @return ConnectionInterface
     */
    private function getConnection($Name)
    {
        return self::$InstanceCache[$this->getHash($Name)];
    }
}
