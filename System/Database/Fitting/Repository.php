<?php
namespace SPHERE\System\Database\Fitting;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;

/**
 * Class Repository
 * @package SPHERE\System\Database\Fitting
 */
class Repository extends EntityRepository implements ObjectRepository, Selectable
{

    /**
     * @return int
     */
    public function count()
    {

        return $this->createQueryBuilder('e')->select('count(e)')->getQuery()
            ->useQueryCache(true)->useResultCache(true)
            ->getSingleScalarResult();
    }

    /**
     * @param $Criteria
     *
     * @return int
     */
    public function countBy($Criteria = array())
    {

        return $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName)->count($Criteria);
    }
}
