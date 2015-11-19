<?php
namespace SPHERE\Application\Education\Lesson\Term\Service;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use SPHERE\System\Database\Binding\AbstractSetup;

/**
 * Class Setup
 *
 * @package SPHERE\Application\Education\Lesson\Term\Service
 */
class Setup extends AbstractSetup
{

    /**
     * @param bool $Simulate
     *
     * @return string
     */
    public function setupDatabaseSchema($Simulate = true)
    {

        $Schema = clone $this->getConnection()->getSchema();
        $tblYear = $this->setTableYear($Schema);
        $tblPeriod = $this->setTablePeriod($Schema);
        $this->setTableYearPeriod($Schema, $tblYear, $tblPeriod);
        /**
         * Migration & Protocol
         */
        $this->getConnection()->addProtocol(__CLASS__);
        $this->getConnection()->setMigration($Schema, $Simulate);
        return $this->getConnection()->getProtocol($Simulate);
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableYear(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblYear');
        if (!$this->getConnection()->hasColumn('tblYear', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblYear', 'Description')) {
            $Table->addColumn('Description', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTablePeriod(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblPeriod');
        if (!$this->getConnection()->hasColumn('tblPeriod', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblPeriod', 'Description')) {
            $Table->addColumn('Description', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblPeriod', 'FromDate')) {
            $Table->addColumn('FromDate', 'datetime', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblPeriod', 'ToDate')) {
            $Table->addColumn('ToDate', 'datetime', array('notnull' => false));
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblYear
     * @param Table  $tblPeriod
     *
     * @return Table
     */
    private function setTableYearPeriod(Schema &$Schema, Table $tblYear, Table $tblPeriod)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblYearPeriod');
        $this->getConnection()->addForeignKey($Table, $tblYear);
        $this->getConnection()->addForeignKey($Table, $tblPeriod);
        return $Table;
    }
}
