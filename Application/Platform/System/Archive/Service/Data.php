<?php
namespace SPHERE\Application\Platform\System\Archive\Service;

use SPHERE\Application\Platform\Gatekeeper\Authorization\Account\Service\Entity\TblAccount;
use SPHERE\Application\Platform\Gatekeeper\Authorization\Consumer\Service\Entity\TblConsumer;
use SPHERE\Application\Platform\System\Archive\Service\Entity\TblArchive;
use SPHERE\System\Database\Binding\AbstractData;
use SPHERE\System\Database\Extender\AbstractEntity;

/**
 * Class Data
 *
 * @package SPHERE\Application\Platform\System\Archive\Service
 */
class Data extends AbstractData
{

    /**
     * @return void
     */
    public function setupDatabaseContent()
    {
        // TODO: Implement setupDatabaseContent() method.
    }

    /**
     * @return TblArchive[]|bool
     */
    public function getArchiveAll()
    {

        $EntityList = $this->getConnection()->getEntityManager()->getEntity('TblArchive')->findAll();
        return ( empty( $EntityList ) ? false : $EntityList );
    }

    /**
     * @param TblConsumer $tblConsumer
     *
     * @return bool|TblArchive[]
     */
    public function getArchiveAllByConsumer(TblConsumer $tblConsumer)
    {

        $EntityList = $this->getConnection()->getEntityManager()->getEntity('TblArchive')->findBy(array(
            TblArchive::SERVICE_TBL_CONSUMER => $tblConsumer->getId()
        ));
        return ( empty( $EntityList ) ? false : $EntityList );
    }

    /**
     * @param string           $DatabaseName
     * @param null|TblAccount  $tblAccount
     * @param null|TblConsumer $tblConsumer
     * @param null|AbstractEntity     $Entity
     * @param int              $Type
     *
     * @return false|TblArchive
     */
    public function createArchiveEntry(
        $DatabaseName,
        TblAccount $tblAccount = null,
        TblConsumer $tblConsumer = null,
        AbstractEntity $Entity = null,
        $Type = TblArchive::ARCHIVE_TYPE_CREATE
    ) {

        $Manager = $this->getConnection()->getEntityManager();

        $Entity = ( $Entity ? serialize($this->persistData($Entity)) : null );

        $Archive = new TblArchive($Type);
        $Archive->setArchiveDatabase($DatabaseName);
        $Archive->setArchiveTimestamp(time());
        if ($tblAccount) {
            $Archive->setServiceTblAccount($tblAccount);
            $Archive->setAccountUsername($tblAccount->getUsername());
        }
        if ($tblConsumer) {
            $Archive->setServiceTblConsumer($tblConsumer);
            $Archive->setConsumerName($tblConsumer->getName());
            $Archive->setConsumerAcronym($tblConsumer->getAcronym());
        }
        $Archive->setEntity($Entity);
        $Manager->saveEntity($Archive);

        return $Archive;
    }

    /**
     * @param AbstractEntity $Entity
     *
     * @return array
     */
    private function persistData(AbstractEntity $Entity)
    {

        $Data = array();
        $Class = new \ReflectionClass($Entity);
        $PropertyList = $Class->getProperties();
        /** @var \ReflectionProperty $Property */
        foreach ((array)$PropertyList as $Property) {
            if ($Class->hasMethod('get'.$Property->getName())) {
                $Data[$Property->getName()] = $Entity->{'get'.$Property->getName()}();
            }
        }
        $Data['EntityName'] = $Class->getShortName();
        return $this->followData($Data);
    }

    /**
     * @param array $Data
     *
     * @return array
     */
    private function followData($Data)
    {

        foreach ((array)$Data as $Key => $Value) {
            if ($Value instanceof AbstractEntity) {
                $Data[$Key] = $this->persistData($Value);
            }
            if ($Value instanceof \DateTime) {
                $Data[$Key] = $Value->getTimestamp();
            }
        }
        return $Data;
    }
}
