<?php
namespace SPHERE\System\Authenticator\Handler;

use SPHERE\System\Config\Reader\ReaderInterface;
use SPHERE\System\Debugger\DebuggerFactory;
use SPHERE\System\Debugger\Logger\ErrorLogger;

/**
 * Class AbstractHandler
 * @package SPHERE\System\Authenticator\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{

    /** @var string $Secret */
    protected $Secret = '';

    /**
     * @param $Name
     * @param ReaderInterface $Config
     * @return HandlerInterface
     */
    public function setConfig($Name, ReaderInterface $Config = null)
    {
        $Value = $Config->getValue($Name);
        if ($Value) {
            $Secret = $Value->getContainer('Secret');
            if ($Secret) {
                $this->Secret = (string)$Secret;
            } else {
                (new DebuggerFactory())->createLogger(new ErrorLogger())
                    ->addLog(__METHOD__ . ' Error: Configuration not available');
            }
        } else {
            (new DebuggerFactory())->createLogger(new ErrorLogger())
                ->addLog(__METHOD__ . ' Error: Configuration not available');
        }
    }

    /**
     * @param $Value
     */
    protected function preventXSS(&$Value)
    {

        $Value = strip_tags($Value);
    }
}
