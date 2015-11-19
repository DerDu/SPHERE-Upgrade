<?php
namespace SPHERE\System\Database\Driver;

use SPHERE\System\Database\DatabaseInterface;

/**
 * Interface DriverInterface
 * @package SPHERE\System\Database\Driver
 */
interface DriverInterface extends DatabaseInterface
{
    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return string
     */
    public function getDefaultPort();
}
