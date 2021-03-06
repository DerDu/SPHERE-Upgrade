<?php
namespace SPHERE\Application\Setting\Consumer\Responsibility\Service;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use SPHERE\System\Database\Binding\AbstractSetup;

/**
 * Class Setup
 *
 * @package SPHERE\Application\Setting\Consumer\Responsibility\Service
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
        $this->setTableResponsibility($Schema);
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
    private function setTableResponsibility(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblResponsibility');
        if (!$this->getConnection()->hasColumn('tblResponsibility', 'serviceTblCompany')) {
            $Table->addColumn('serviceTblCompany', 'bigint');
        }

        return $Table;
    }
}
