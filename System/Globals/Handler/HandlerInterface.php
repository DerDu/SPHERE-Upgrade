<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigContainer;
use SPHERE\System\Config\Loader\LoaderInterface;
use SPHERE\System\Globals\GlobalsInterface;

/**
 * Interface HandlerInterface
 * @package SPHERE\System\Globals\Handler
 */
interface HandlerInterface extends GlobalsInterface
{
    /**
     * @param LoaderInterface $Config
     * @return HandlerInterface
     */
    public function setConfig(LoaderInterface $Config = null);

    /**
     * @return ConfigContainer
     */
    public function getConfig();

    /**
     * @param string $Key
     * @param mixed $Value
     * @return HandlerInterface
     */
    public function setValue($Key, $Value);

    /**
     * @param string $Key
     * @return null|mixed
     */
    public function getValue($Key);
}
