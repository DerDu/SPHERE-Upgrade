<?php
namespace SPHERE\Application\Platform\Gatekeeper\Authorization\Consumer\Service;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use SPHERE\System\Database\Binding\AbstractSetup;

/**
 * Class Setup
 *
 * @package SPHERE\Application\Platform\Gatekeeper\Authorization\Consumer\Service
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
        $this->setTableConsumer($Schema);
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
    private function setTableConsumer(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblConsumer');
        if (!$this->getConnection()->hasColumn('tblConsumer', 'Acronym')) {
            $Table->addColumn('Acronym', 'string');
        }
        if (!$this->getConnection()->hasIndex($Table, array('Acronym'))) {
            $Table->addUniqueIndex(array('Acronym'));
        }
        if (!$this->getConnection()->hasColumn('tblConsumer', 'Name')) {
            $Table->addColumn('Name', 'string');
        }

        return $Table;
    }
}
