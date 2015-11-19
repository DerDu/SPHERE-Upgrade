<?php
namespace SPHERE\System\Config\Reader;

use SPHERE\System\Config\ConfigInterface;
use SPHERE\System\Config\ConfigContainer;

/**
 * Interface ReaderInterface
 * @package SPHERE\System\Config\Reader
 */
interface ReaderInterface extends ConfigInterface
{
    /**
     * @param string $File
     * @return ReaderInterface
     */
    public function setConfig($File);

    /**
     * @param string $Key
     * @return mixed|null|ConfigContainer
     */
    public function getValue($Key);
}
