<?php
namespace SPHERE\Application\People\Relationship\Service\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use SPHERE\Application\People\Relationship\Relationship;
use SPHERE\System\Database\Fitting\Element;

/**
 * @Entity
 * @Table(name="tblType")
 * @Cache(usage="READ_ONLY")
 */
class TblType extends Element
{

    const ATTR_NAME = 'Name';
    const ATTR_DESCRIPTION = 'Description';
    const ATTR_IS_LOCKED = 'IsLocked';
    const ATTR_TBL_GROUP = 'tblGroup';

    /**
     * @Column(type="string")
     */
    protected $Name;
    /**
     * @Column(type="string")
     */
    protected $Description;
    /**
     * @Column(type="boolean")
     */
    protected $IsLocked;
    /**
     * @Column(type="bigint")
     */
    protected $tblGroup;

    /**
     * @return string
     */
    public function getDescription()
    {

        return $this->Description;
    }

    /**
     * @param string $Description
     */
    public function setDescription($Description)
    {

        $this->Description = $Description;
    }

    /**
     * @return string
     */
    public function getName()
    {

        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName($Name)
    {

        $this->Name = $Name;
    }

    /**
     * @return bool
     */
    public function getIsLocked()
    {

        return (bool)$this->IsLocked;
    }

    /**
     * @param bool $IsLocked
     */
    public function setIsLocked($IsLocked)
    {

        $this->IsLocked = (bool)$IsLocked;
    }

    /**
     * @return bool|TblGroup
     */
    public function getTblGroup()
    {

        if (null === $this->tblGroup) {
            return false;
        } else {
            return Relationship::useService()->getGroupById($this->tblGroup);
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
