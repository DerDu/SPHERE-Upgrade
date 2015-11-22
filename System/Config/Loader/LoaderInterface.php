<?php
namespace SPHERE\System\Config\Loader;

use SPHERE\System\Config\ConfigInterface;
use SPHERE\System\Config\ConfigContainer;

/**
 * Interface LoaderInterface
 * @package SPHERE\System\Config\Loader
 */
interface LoaderInterface extends ConfigInterface
{
    /**
     * @param array $Array
     * @return LoaderInterface
     */
    public function setConfig($Array);

    /**
     * @param string $Key
     * @return mixed|null|ConfigContainer
     */
    public function getValue($Key);

    /**
     * @return ConfigContainer
     */
    public function getConfig();
}
