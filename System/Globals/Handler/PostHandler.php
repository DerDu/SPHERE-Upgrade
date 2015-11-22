<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Config\Loader\ArrayLoader;

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
        $this->setConfig((new ConfigFactory())->createLoader($_POST, new ArrayLoader()));
    }
}
