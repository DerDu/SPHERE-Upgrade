<?php
namespace SPHERE\System\Config\Loader;

use SPHERE\System\Config\ConfigContainer;

/**
 * Class AbstractLoader
 * @package SPHERE\System\Config\Loader
 */
abstract class AbstractLoader implements LoaderInterface
{

    /** @var ConfigContainer $Registry */
    protected $Registry = null;

    /**
     * @param string $Key
     * @return mixed|null|ConfigContainer
     */
    public function getValue($Key)
    {
        return $this->Registry->getContainer($Key);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->Registry;
    }
}
