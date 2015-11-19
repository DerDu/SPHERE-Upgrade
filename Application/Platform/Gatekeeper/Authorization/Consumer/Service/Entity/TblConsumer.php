<?php
namespace SPHERE\Application\Platform\Gatekeeper\Authorization\Consumer\Service\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use SPHERE\System\Database\Extender\AbstractEntity;

/**
 * @Entity
 * @Table(name="tblConsumer")
 * @Cache(usage="READ_ONLY")
 */
class TblConsumer extends AbstractEntity
{

    const ATTR_ACRONYM = 'Acronym';
    const ATTR_NAME = 'Name';

    /**
     * @Column(type="string")
     */
    protected $Acronym;
    /**
     * @Column(type="string")
     */
    protected $Name;

    /**
     * @param string $Acronym
     */
    public function __construct($Acronym)
    {

        $this->Acronym = $Acronym;
    }

    /**
     * @return string
     */
    public function getAcronym()
    {

        return $this->Acronym;
    }

    /**
     * @param string $Acronym
     */
    public function setAcronym($Acronym)
    {

        $this->Acronym = $Acronym;
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
}
