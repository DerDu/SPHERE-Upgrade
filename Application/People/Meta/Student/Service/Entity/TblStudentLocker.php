<?php
namespace SPHERE\Application\People\Meta\Student\Service\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use SPHERE\System\Database\Extender\AbstractEntity;

/**
 * @Entity
 * @Table(name="tblStudentLocker")
 * @Cache(usage="READ_ONLY")
 */
class TblStudentLocker extends AbstractEntity
{

    /**
     * @Column(type="string")
     */
    protected $LockerNumber;
    /**
     * @Column(type="string")
     */
    protected $LockerLocation;
    /**
     * @Column(type="string")
     */
    protected $KeyNumber;

    /**
     * @return string
     */
    public function getLockerNumber()
    {

        return $this->LockerNumber;
    }

    /**
     * @param string $LockerNumber
     */
    public function setLockerNumber($LockerNumber)
    {

        $this->LockerNumber = $LockerNumber;
    }

    /**
     * @return string
     */
    public function getLockerLocation()
    {

        return $this->LockerLocation;
    }

    /**
     * @param string $LockerLocation
     */
    public function setLockerLocation($LockerLocation)
    {

        $this->LockerLocation = $LockerLocation;
    }

    /**
     * @return string
     */
    public function getKeyNumber()
    {

        return $this->KeyNumber;
    }

    /**
     * @param string $KeyNumber
     */
    public function setKeyNumber($KeyNumber)
    {

        $this->KeyNumber = $KeyNumber;
    }
}
