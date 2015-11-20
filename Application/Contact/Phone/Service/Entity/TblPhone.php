<?php
namespace SPHERE\Application\Contact\Phone\Service\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use SPHERE\System\Database\Extender\AbstractEntity;

/**
 * @Entity
 * @Table(name="tblPhone")
 * @Cache(usage="READ_ONLY")
 */
class TblPhone extends AbstractEntity
{

    const ATTR_NUMBER = 'Number';

    /**
     * @Column(type="string")
     */
    protected $Number;

    /**
     * @return string
     */
    public function getNumber()
    {

        return $this->Number;
    }

    /**
     * @param string $Number
     */
    public function setNumber($Number)
    {

        $this->Number = $Number;
    }
}
