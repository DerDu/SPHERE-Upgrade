<?php
namespace SPHERE\System\Database\Fitting;

use Doctrine\\Platforms\AbstractPlatform;
use Doctrine\\Schema\AbstractSchemaManager;
use Doctrine\\Schema\Schema;
use Doctrine\\Schema\Table;
use Doctrine\DBAL\Platforms\AbstractPlatform;use Doctrine\DBAL\Schema\Schema;use Doctrine\DBAL\Schema\Table;use SPHERE\Common\Frontend\Icon\Repository\Flash;
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

/**
 * Class Structure
 *
 * @package SPHERE\Application
 */
class Structure
{

    /** @var null|ConnectionInterface $Connection */
    private $Connection = null;
    /** @var array $Protocol */
    private $Protocol = array();

    /**
     * @param ConnectionInterface $Connection
     */
    public function __construct(ConnectionInterface $Connection)
    {

        $this->Connection = $Connection;
    }

    /**
     * @return AbstractPlatform
     */
    public function getPlatform()
    {

        return $this->Connection->getConnection()->getConnection()->getDatabasePlatform();
    }

    /**
     * @param Schema $Schema
     * @param string     $Name
     *
     * @return Table
     * @throws \Doctrine\\Schema\SchemaException
     */
    public function createTable(Schema &$Schema, $Name)
    {

        if (!$this->Database->hasTable($Name)) {
            $Table = $Schema->createTable($Name);
            $Column = $Table->addColumn('Id', 'bigint');
            $Column->setAutoincrement(true);
            $Table->setPrimaryKey(array('Id'));
        }
        $Table = $Schema->getTable($Name);
        if (!$this->Database->hasColumn($Name, 'EntityCreate')) {
            $Table->addColumn('EntityCreate', 'datetime', array('notnull' => false));
        }
        if (!$this->Database->hasColumn($Name, 'EntityUpdate')) {
            $Table->addColumn('EntityUpdate', 'datetime', array('notnull' => false));
        }
        return $Table;
    }

    /**
     * @param Table $KeyTarget Foreign Key (Column: KeySource Name)
     * @param Table $KeySource Foreign Data (Column: Id)
     * @param bool $AllowNull
     */
    public function addForeignKey(Table &$KeyTarget, Table $KeySource, $AllowNull = false)
    {

        if (!$this->Database->hasColumn($KeyTarget->getName(), $KeySource->getName())) {
            if ($AllowNull) {
                $KeyTarget->addColumn($KeySource->getName(), 'bigint', array(
                    'notnull' => false
                ));
            } else {
                $KeyTarget->addColumn($KeySource->getName(), 'bigint');
            }
            if ($this->Database->getPlatform()->supportsForeignKeyConstraints()) {
                if ($AllowNull) {
                    $KeyTarget->addForeignKeyConstraint($KeySource, array($KeySource->getName()), array('Id'), array(
                        'notnull' => false
                    ));
                } else {
                    $KeyTarget->addForeignKeyConstraint($KeySource, array($KeySource->getName()), array('Id'));
                }
            }
        }
    }

    /**
     * @param Schema $Schema
     * @param bool       $Simulate
     */
    public function setMigration(Schema &$Schema, $Simulate = true)
    {

        $Statement = $this->Database->getSchema()->getMigrateToSql($Schema,
            $this->Database->getPlatform()
        );
        if (!empty( $Statement )) {
            foreach ((array)$Statement as $Query) {
                $this->Database->addProtocol($Query);
                if (!$Simulate) {
                    $this->Database->setStatement($Query);
                }
            }
        }
    }

    /**
     * @param string $ViewName
     *
     * @return bool
     */
    public function hasView($ViewName)
    {

        return $this->Database->hasView($ViewName);
    }

    /**
     * @return SchemaManager
     */
    public function getSchemaManager()
    {

        return $this->Database->getSchemaManager();
    }

    /**
     * @return Schema
     */
    public function getSchema()
    {

        return $this->Database->getSchema();
    }

    /**
     * @param string $TableName
     * @param string $ColumnName
     *
     * @return bool
     */
    public function hasColumn($TableName, $ColumnName)
    {

        return $this->Database->hasColumn($TableName, $ColumnName);
    }

    /**
     * @param Table $Table
     * @param array     $ColumnList
     *
     * @return bool
     */
    public function hasIndex(Table $Table, $ColumnList)
    {

        return $this->Database->hasIndex($Table, $ColumnList);
    }

    /**
     * @param string $TableName
     *
     * @return bool
     */
    public function hasTable($TableName)
    {

        return $this->Database->hasTable($TableName);
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
