<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Config\Reader\ArrayReader;

/**
 * Class GetHandler
 *
 * @package SPHERE\System\Globals\Handler
 */
class GetHandler extends AbstractHandler implements HandlerInterface
{

    /**
     * GetHandler constructor.
     */
    public function __construct()
    {

        $this->setConfig((new ConfigFactory())->createReader($_GET, new ArrayReader()));
    }
}
