<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigContainer;
use SPHERE\System\Config\Loader\LoaderInterface;

/**
 * Class AbstractHandler
 * @package SPHERE\System\Globals\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    /** @var ConfigContainer $Global */
    protected $Global = array();

    /**
     * @param LoaderInterface|null $Config
     * @return mixed
     */
    public function setConfig(LoaderInterface $Config = null)
    {
        $this->Global = $Config->getConfig();
    }

    /**
     * @return ConfigContainer
     */
    public function getConfig()
    {
        return $this->Global;
    }

    /**
     * @param string $Key
     * @return mixed
     */
    public function getValue($Key)
    {
        $Key = explode('.', $Key);
        $Value = $this->Global;
        array_walk($Key, function ($Key) use (&$Value) {
            if ($Value) {
                $Value = $Value->getContainer($Key);
            }
        });
        return $Value;
    }

    /**
     * @param string $Key
     * @param mixed $Value
     * @return mixed
     */
    public function setValue($Key, $Value)
    {

        $KeyList = explode('.', $Key);
        $Container = $this->Global;
        $Target = (count($KeyList) - 1);

        foreach ((array)$KeyList as $Index => $Key) {

        }

        var_dump($this->Global);

        return $this;
    }
}
