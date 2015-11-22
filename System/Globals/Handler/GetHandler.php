<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Config\Loader\ArrayLoader;

/**
 * Class GetHandler
 * @package SPHERE\System\Globals\Handler
 */
class GetHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * GetHandler constructor.
     */
    public function __construct()
    {
        $this->setConfig((new ConfigFactory())->createLoader($_GET, new ArrayLoader()));
    }
}
