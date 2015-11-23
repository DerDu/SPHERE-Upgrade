<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigContainer;
use SPHERE\System\Config\Reader\ReaderInterface;
use SPHERE\System\Globals\GlobalsInterface;

/**
 * Interface HandlerInterface
 * @package SPHERE\System\Globals\Handler
 */
interface HandlerInterface extends GlobalsInterface
{
    /**
     * @param ReaderInterface $Config
     * @return HandlerInterface
     */
    public function setConfig(ReaderInterface $Config = null);

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
     * @return null|mixed|ConfigContainer
     */
    public function getValue($Key);
}
