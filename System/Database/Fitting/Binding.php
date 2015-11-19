<?php
namespace SPHERE\System\Database\Fitting;

use SPHERE\System\Database\Connection\ConnectionInterface;

class Binding
{
    /** @var null|ConnectionInterface $Connection */
    private $Connection = null;
    /** @var string $EntityPath */
    private $EntityPath = '';
    /** @var string $EntityNamespace */
    private $EntityNamespace = '';

    /**
     * @param ConnectionInterface $Connection
     * @param string     $EntityNamespace
     */
    public function __construct( ConnectionInterface $Connection, $EntityNamespace)
    {

        $this->Connection = $Connection;
        $this->EntityNamespace = $EntityNamespace;
    }

    /**
     * @return Manager
     */
    public function getEntityManager()
    {

        return $this->Connection->createEntityManager($this->EntityPath, $this->EntityNamespace);
    }

    /**
     * @param $Statement
     *
     * @return int The number of affected rows
     */
    public function setStatement($Statement)
    {

        return $this->Connection->setStatement($Statement);
    }

    /**
     * @param $Statement
     *
     * @return array
     */
    public function getStatement($Statement)
    {

        return $this->Connection->getStatement($Statement);
    }

    /**
     * @return string
     */
    public function getConnection()
    {

        return $this->Connection->getDatabase();
    }

    /**
     * @param string $Item
     */
    public function addProtocol($Item)
    {

        $this->Connection->addProtocol($Item);
    }


    /**
     * @param bool $Simulate
     *
     * @return string
     */
    public function getProtocol($Simulate = false)
    {

        return $this->Connection->getProtocol($Simulate);
    }

    /**
     * @return string
     */
    public function getEntityNamespace()
    {

        return $this->EntityNamespace;
    }
}
