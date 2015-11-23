<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Config\Reader\ArrayReader;

/**
 * Class PostHandler
 * @package SPHERE\System\Globals\Handler
 */
class PostHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * GetHandler constructor.
     */
    public function __construct()
    {
        $this->setConfig((new ConfigFactory())->createReader($_POST, new ArrayReader()));
    }
}
