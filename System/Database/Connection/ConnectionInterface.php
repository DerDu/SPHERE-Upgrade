<?php
namespace SPHERE\System\Database\Connection;

use SPHERE\System\Config\Reader\ReaderInterface;
use SPHERE\System\Database\DatabaseInterface;

/**
 * Interface ConnectionInterface
 * @package SPHERE\System\Database\Connection
 */
interface ConnectionInterface extends DatabaseInterface
{
    /**
     * @param string $Name
     * @param ReaderInterface $Config
     * @return ConnectionInterface
     */
    public function setConfig($Name, ReaderInterface $Config = null);

    /**
     * @return null|ConnectionInterface
     */
    public function getConnection();

    public function createEntityManager($EntityPath, $EntityNamespace);
}
