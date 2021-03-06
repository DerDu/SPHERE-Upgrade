<?php
namespace SPHERE\System\Globals;

use SPHERE\System\Globals\Handler\GetHandler;
use SPHERE\System\Globals\Handler\HandlerInterface;
use SPHERE\System\Debugger\DebuggerFactory;

/**r
 * Class GlobalsFactory
 * @package SPHERE\System\Globals
 */
class GlobalsFactory implements GlobalsInterface
{
    /**
     * @var HandlerInterface
     */
    private static $InstanceCache = array();

    /**
     * @param HandlerInterface $Handler
     * @return HandlerInterface
     */
    public function createHandler(HandlerInterface $Handler = null)
    {
        if (!$this->isAvailable($Handler)) {
            if (null === $Handler) {
                $Handler = new GetHandler();
            }
            (new DebuggerFactory())->createLogger()->addLog(__METHOD__ . ': ' . get_class($Handler));
            $this->setHandler($Handler);
        }
        return $this->getHandler($Handler);
    }

    /**
     * @param HandlerInterface $Handler
     * @return bool
     */
    private function isAvailable($Handler)
    {
        return isset(self::$InstanceCache[$this->getHash($Handler)]);
    }

    /**
     * @param string $Handler
     * @return string
     */
    private function getHash($Handler)
    {
        return sha1(get_class($Handler));
    }

    /**
     * @param HandlerInterface $Handler
     */
    private function setHandler(HandlerInterface $Handler)
    {
        self::$InstanceCache[$this->getHash($Handler)] = $Handler;
    }

    /**
     * @param HandlerInterface $Handler
     * @return HandlerInterface
     */
    private function getHandler(HandlerInterface $Handler)
    {
        return self::$InstanceCache[$this->getHash($Handler)];
    }
}
