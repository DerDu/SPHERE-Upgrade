<?php
namespace SPHERE\Application\Platform\System\Protocol;

use SPHERE\Application\Platform\Gatekeeper\Authorization\Account\Account;
use SPHERE\Application\Platform\System\Archive\Archive;
use SPHERE\Application\Platform\System\Archive\Service\Entity\TblArchive;
use SPHERE\Application\Platform\System\Protocol\Service\Data;
use SPHERE\Application\Platform\System\Protocol\Service\Entity\TblProtocol;
use SPHERE\Application\Platform\System\Protocol\Service\Setup;
use SPHERE\System\Database\Extender\AbstractService;
use SPHERE\System\Database\Extender\AbstractEntity;

/**
 * Class Service
 *
 * @package SPHERE\Application\System\Platform\Protocol
 */
class Service extends AbstractService
{

    /**
     * @param bool $doSimulation
     * @param bool $withData
     *
     * @return string
     */
    public function setupService($doSimulation, $withData)
    {

        return (new Setup($this->getStructure()))->setupDatabaseSchema($doSimulation);
    }

    /**
     * @return bool|TblProtocol[]
     */
    public function getProtocolAll()
    {

        return (new Data($this->getBinding()))->getProtocolAll();
    }

    /**
     * @param string  $DatabaseName
     * @param AbstractEntity $Entity
     *
     * @return false|TblProtocol
     */
    public function createInsertEntry(
        $DatabaseName,
        AbstractEntity $Entity
    ) {

        $tblAccount = Account::useService()->getAccountBySession();
        if ($tblAccount) {
            $tblConsumer = $tblAccount->getServiceTblConsumer();
        } else {
            $tblConsumer = null;
        }

        Archive::useService()->createArchiveEntry(
            $DatabaseName,
            ( $tblAccount ? $tblAccount : null ),
            ( $tblConsumer ? $tblConsumer : null ),
            $Entity, TblArchive::ARCHIVE_TYPE_CREATE
        );

        return (new Data($this->getBinding()))->createProtocolEntry(
            $DatabaseName,
            ( $tblAccount ? $tblAccount : null ),
            ( $tblConsumer ? $tblConsumer : null ),
            null,
            $Entity
        );
    }

    /**
     * @param string  $DatabaseName
     * @param AbstractEntity $From
     * @param AbstractEntity $To
     *
     * @return false|TblProtocol
     */
    public function createUpdateEntry(
        $DatabaseName,
        AbstractEntity $From,
        AbstractEntity $To
    ) {

        $tblAccount = Account::useService()->getAccountBySession();
        if ($tblAccount) {
            $tblConsumer = $tblAccount->getServiceTblConsumer();
        } else {
            $tblConsumer = null;
        }

        if (( $Protocol = (new Data($this->getBinding()))->createProtocolEntry(
            $DatabaseName,
            ( $tblAccount ? $tblAccount : null ),
            ( $tblConsumer ? $tblConsumer : null ),
            $From,
            $To
        ) )
        ) {
            Archive::useService()->createArchiveEntry(
                $DatabaseName,
                ( $tblAccount ? $tblAccount : null ),
                ( $tblConsumer ? $tblConsumer : null ),
                $To, TblArchive::ARCHIVE_TYPE_UPDATE
            );
        };
        return $Protocol;
    }

    /**
     * @param string  $DatabaseName
     * @param AbstractEntity $Entity
     *
     * @return false|TblProtocol
     */
    public function createDeleteEntry(
        $DatabaseName,
        AbstractEntity $Entity = null
    ) {

        $tblAccount = Account::useService()->getAccountBySession();
        if ($tblAccount) {
            $tblConsumer = $tblAccount->getServiceTblConsumer();
        } else {
            $tblConsumer = null;
        }

        return (new Data($this->getBinding()))->createProtocolEntry(
            $DatabaseName,
            ( $tblAccount ? $tblAccount : null ),
            ( $tblConsumer ? $tblConsumer : null ),
            $Entity,
            null
        );
    }
}
