<?php
namespace SPHERE\System\Database\Connection;

use Doctrine\ORM\EntityManager;
use MOC\V\Component\Database\Component\IBridgeInterface;
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
     * @return null|IBridgeInterface
     */
    public function getConnection();

    /**
     * @param string $EntityNamespace
     *
     * @return EntityManager
     */
    public function createEntityManager($EntityNamespace);
}
