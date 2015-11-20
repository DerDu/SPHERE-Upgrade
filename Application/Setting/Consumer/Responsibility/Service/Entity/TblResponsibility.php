<?php
namespace SPHERE\Application\Setting\Consumer\Responsibility\Service\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use SPHERE\Application\Corporation\Company\Company;
use SPHERE\Application\Corporation\Company\Service\Entity\TblCompany;
use SPHERE\System\Database\Extender\AbstractEntity;

/**
 * @Entity
 * @Table(name="tblResponsibility")
 * @Cache(usage="NONSTRICT_READ_WRITE")
 */
class TblResponsibility extends AbstractEntity
{

    const SERVICE_TBL_COMPANY = 'serviceTblCompany';

    /**
     * @Column(type="bigint")
     */
    protected $serviceTblCompany;

    /**
     * @return bool|TblCompany
     */
    public function getServiceTblCompany()
    {

        if (null === $this->serviceTblCompany) {
            return false;
        } else {
            return Company::useService()->getCompanyById($this->serviceTblCompany);
        }
    }

    /**
     * @param TblCompany|null $tblCompany
     */
    public function setServiceTblCompany(TblCompany $tblCompany = null)
    {

        $this->serviceTblCompany = ( null === $tblCompany ? null : $tblCompany->getId() );
    }
}
