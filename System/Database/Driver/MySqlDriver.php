<?php
namespace SPHERE\System\Database\Driver;

/**
 * Class MySqlDriver
 * @package SPHERE\System\Database\Driver
 */
class MySqlDriver extends AbstractDriver implements DriverInterface
{
    /**
     * @return string
     */
    public function getIdentifier()
    {

        return 'pdo_mysql';
    }

    /**
     * @return string
     */
    public function getDefaultPort()
    {
        return 3306;
    }
}
