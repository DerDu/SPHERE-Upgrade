<?php
namespace SPHERE\Application\Corporation\Group\Service;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use SPHERE\System\Database\Binding\AbstractSetup;

/**
 * Class Setup
 *
 * @package SPHERE\Application\Corporation\Group\Service
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

        /**
         * Table
         */
        $Schema = clone $this->getConnection()->getSchema();
        $tblGroup = $this->setTableGroup($Schema);
        $this->setTableMember($Schema, $tblGroup);
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
    private function setTableGroup(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblGroup');
        if (!$this->getConnection()->hasColumn('tblGroup', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblGroup', 'Description')) {
            $Table->addColumn('Description', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblGroup', 'Remark')) {
            $Table->addColumn('Remark', 'text');
        }
        if (!$this->getConnection()->hasColumn('tblGroup', 'IsLocked')) {
            $Table->addColumn('IsLocked', 'boolean');
        }
        if (!$this->getConnection()->hasColumn('tblGroup', 'MetaTable')) {
            $Table->addColumn('MetaTable', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblGroup
     *
     * @return Table
     */
    private function setTableMember(Schema &$Schema, Table $tblGroup)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblMember');
        if (!$this->getConnection()->hasColumn('tblMember', 'serviceTblCompany')) {
            $Table->addColumn('serviceTblCompany', 'bigint', array('notnull' => false));
        }
        $this->getConnection()->addForeignKey($Table, $tblGroup);
        return $Table;
    }
}
