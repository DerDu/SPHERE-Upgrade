<?php
namespace SPHERE\Application\People\Group\Service\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use SPHERE\Application\People\Group\Group;
use SPHERE\Application\People\Person\Person;
use SPHERE\Application\People\Person\Service\Entity\TblPerson;
use SPHERE\System\Database\Fitting\Element;

/**
 * @Entity
 * @Table(name="tblMember")
 * @Cache(usage="NONSTRICT_READ_WRITE")
 */
class TblMember extends Element
{

    const ATTR_TBL_GROUP = 'tblGroup';
    const SERVICE_TBL_PERSON = 'serviceTblPerson';

    /**
     * @Column(type="bigint")
     */
    protected $tblGroup;
    /**
     * @Column(type="bigint")
     */
    protected $serviceTblPerson;

    /**
     * @return bool|TblPerson
     */
    public function getServiceTblPerson()
    {

        if (null === $this->serviceTblPerson) {
            return false;
        } else {
            return Person::useService()->getPersonById($this->serviceTblPerson);
        }
    }

    /**
     * @param TblPerson|null $tblPerson
     */
    public function setServiceTblPerson(TblPerson $tblPerson = null)
    {

        $this->serviceTblPerson = ( null === $tblPerson ? null : $tblPerson->getId() );
    }

    /**
     * @return bool|TblGroup
     */
    public function getTblGroup()
    {

        if (null === $this->tblGroup) {
            return false;
        } else {
            return Group::useService()->getGroupById($this->tblGroup);
        }
    }

    /**
     * @param null|TblGroup $tblGroup
     */
    public function setTblGroup(TblGroup $tblGroup = null)
    {

        $this->tblGroup = ( null === $tblGroup ? null : $tblGroup->getId() );
    }
}
