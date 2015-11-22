<?php
namespace SPHERE\System\Config\Loader;

use SPHERE\System\Config\ConfigContainer;

/**
 * Class ArrayLoader
 * @package SPHERE\System\Config\Loader
 */
class ArrayLoader extends AbstractLoader implements LoaderInterface
{
    /**
     * @param array $Array
     * @return LoaderInterface
     */
    public function setConfig($Array)
    {
        $this->Registry = new ConfigContainer($Array);
        return $this;
    }
}
