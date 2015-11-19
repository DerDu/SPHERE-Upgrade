<?php
namespace SPHERE\System\Database\Driver;

/**
 * Class AbstractDriver
 * @package SPHERE\System\Database\Driver
 */
abstract class AbstractDriver implements DriverInterface
{
    /**
     * Driver-Identifier (Doctrine)
     *
     * @return string
     */
    public function __toString()
    {
        return trim($this->getIdentifier());
    }
}
