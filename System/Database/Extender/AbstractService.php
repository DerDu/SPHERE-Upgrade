<?php
namespace SPHERE\System\Database\Extender;

use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Database\Connection\ConnectionInterface;
use SPHERE\System\Database\DatabaseFactory;
use SPHERE\System\Database\Fitting\Binding;

/**
 * Class AbstractService
 * @package SPHERE\System\Database\Extender
 */
abstract class AbstractService
{
    /** @var null|ConnectionInterface $Connection */
    private $Connection = null;

    /** @var null|Binding */
    private $Binding = null;
    /** @var null|Structure */
    private $Structure = null;

    /**
     * AbstractService constructor.
     *
     * @param string $EntityNamespace
     * @param string $Cluster
     * @param string $Application
     * @param null|string $Module
     * @param null|string $Service
     * @param null|string $Consumer
     */
    public function __construct(
        $EntityNamespace,
        $Cluster,
        $Application,
        $Module = null,
        $Service = null,
        $Consumer = null
    ) {
        $DSN = implode(':', array_filter(array($Cluster, $Application, $Module, $Service)));
        $Config = (new ConfigFactory())->createReader(__DIR__ . '/../../Database.ini');
        $this->Connection = (new DatabaseFactory())->createConnection($DSN, $Config);


    }

    /**
     * @return Structure
     */
    final public function getStructure()
    {

        return $this->Structure;
    }

    /**
     * @return Binding
     */
    final public function getBinding()
    {

        return $this->Binding;
    }
}
