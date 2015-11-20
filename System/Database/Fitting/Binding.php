<?php
namespace SPHERE\System\Database\Fitting;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use SPHERE\Common\Frontend\Icon\Repository\Flash;
use SPHERE\Common\Frontend\Icon\Repository\Off;
use SPHERE\Common\Frontend\Icon\Repository\Ok;
use SPHERE\Common\Frontend\Icon\Repository\Transfer;
use SPHERE\Common\Frontend\Icon\Repository\Warning;
use SPHERE\Common\Frontend\Layout\Structure\Layout;
use SPHERE\Common\Frontend\Layout\Structure\LayoutColumn;
use SPHERE\Common\Frontend\Layout\Structure\LayoutGroup;
use SPHERE\Common\Frontend\Layout\Structure\LayoutRow;
use SPHERE\Common\Frontend\Text\Repository\Info;
use SPHERE\Common\Frontend\Text\Repository\Success;
use SPHERE\System\Database\Connection\ConnectionInterface;

class Binding
{

    /** @var null|ConnectionInterface $Connection */
    private $Connection = null;
    /** @var string $EntityNamespace */
    private $EntityNamespace = '';
    /** @var array $Protocol */
    private $Protocol = array();

    /**
     * @param ConnectionInterface $Connection
     * @param string              $EntityNamespace
     */
    public function __construct(ConnectionInterface $Connection, $EntityNamespace)
    {

        $this->EntityNamespace = $EntityNamespace;
        $this->Connection = $Connection;
    }

    /**
     * @return Manager
     */
    public function getEntityManager()
    {

        return new Manager($this->Connection->createEntityManager($this->EntityNamespace), $this->EntityNamespace);
    }

    /**
     * @param $Statement
     *
     * @return int The number of affected rows
     */
    public function setStatement($Statement)
    {

        return $this->Connection->getConnection()->prepareStatement($Statement)->executeWrite();
    }

    /**
     * @param $Statement
     *
     * @return array
     */
    public function getStatement($Statement)
    {

        return $this->Connection->getConnection()->prepareStatement($Statement)->executeRead();
    }

    /**
     * @return AbstractPlatform
     */
    public function getPlatform()
    {

        return $this->Connection->getConnection()->getConnection()->getDatabasePlatform();
    }

    /**
     * @return string
     */
    public function getDatabase()
    {

        return $this->Connection->getConnection()->getConnection()->getDatabase();
    }

    /**
     * @param string $ViewName
     *
     * @return bool
     */
    public function hasView($ViewName)
    {

        return in_array($ViewName, $this->Connection->getConnection()->getSchemaManager()->listViews());
    }

    /**
     * @return Schema
     */
    public function getSchema()
    {

        return $this->getSchemaManager()->createSchema();
    }

    /**
     * @return AbstractSchemaManager
     */
    public function getSchemaManager()
    {

        return $this->Connection->getConnection()->getSchemaManager();
    }

    /**
     * @param string $TableName
     * @param string $ColumnName
     *
     * @return bool
     */
    public function hasColumn($TableName, $ColumnName)
    {

        return in_array(strtolower($ColumnName),
            array_keys($this->getSchemaManager()->listTableColumns($TableName))
        );
    }

    /**
     * @param Table $Table
     * @param array $ColumnList
     *
     * @return bool
     */
    public function hasIndex(Table $Table, $ColumnList)
    {

        if ($Table->columnsAreIndexed($ColumnList)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $TableName
     *
     * @return bool
     */
    public function hasTable($TableName)
    {

        return in_array($TableName, $this->getSchemaManager()->listTableNames());
    }

    /**
     * @param string $Item
     */
    public function addProtocol($Item)
    {

        if (empty( $this->Protocol )) {
            $this->Protocol[] = '<samp>'.$Item.'</samp>';
        } else {
            $this->Protocol[] = '<div>'.new Transfer().'&nbsp;<samp>'.$Item.'</samp></div>';
        }
    }


    /**
     * @param bool $Simulate
     *
     * @return string
     */
    public function getProtocol($Simulate = false)
    {

        if (count($this->Protocol) == 1) {
            $Protocol = new Success(
                new Layout(new LayoutGroup(new LayoutRow(array(
                    new LayoutColumn(new Ok().'&nbsp'.implode('', $this->Protocol), 9),
                    new LayoutColumn(new Off().'&nbsp;Kein Update notwendig', 3)
                ))))
            );
        } else {
            $Protocol = new Info(
                new Layout(new LayoutGroup(new LayoutRow(array(
                    new LayoutColumn(new Flash().'&nbsp;'.implode('', $this->Protocol), 9),
                    new LayoutColumn(
                        ( $Simulate
                            ? new Warning().'&nbsp;Update notwendig'
                            : new Ok().'&nbsp;Update durchgeführt'
                        ), 3)
                ))))
            );
        }
        $this->Protocol = array();
        return $Protocol;
    }
}
