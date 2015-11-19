<?php
namespace SPHERE\Application\Billing\Accounting\Account;

use SPHERE\Application\Billing\Accounting\Account\Service\Data;
use SPHERE\Application\Billing\Accounting\Account\Service\Entity\TblAccount;
use SPHERE\Application\Billing\Accounting\Account\Service\Entity\TblAccountKey;
use SPHERE\Application\Billing\Accounting\Account\Service\Entity\TblAccountKeyType;
use SPHERE\Application\Billing\Accounting\Account\Service\Entity\TblAccountType;
use SPHERE\Application\Billing\Accounting\Account\Service\Setup;
use SPHERE\Common\Frontend\Form\IFormInterface;
use SPHERE\Common\Frontend\Message\Repository\Success;
use SPHERE\Common\Window\Redirect;
use SPHERE\System\Database\Binding\AbstractService;

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

        $Protocol = (new Setup($this->getStructure()))->setupDatabaseSchema($doSimulation);
        if (!$doSimulation && $withData) {
            (new Data($this->getBinding()))->setupDatabaseContent();
        }

        return $Protocol;
    }

    /**
     * @return array|bool|TblAccount[]
     */
    public function getAccountAll()
    {

        return (new Data($this->getBinding()))->getAccountAll();
    }

    /**
     * @param $Id
     *
     * @return bool
     */
    public function changeFibuActivate($Id)
    {

        return (new Data($this->getBinding()))->updateActivateAccount($Id);
    }

    /**
     * @param $Id
     *
     * @return bool
     */
    public function changeFibuDeactivate($Id)
    {

        return (new Data($this->getBinding()))->updateDeactivateAccount($Id);
    }

    /**
     * @return bool|TblAccountKey[]
     */
    public function getKeyValueAll()
    {

        return (new Data($this->getBinding()))->getKeyValueAll();
    }

    /**
     * @return bool|TblAccountType[]
     */
    public function getTypeValueAll()
    {

        return (new Data($this->getBinding()))->getTypeValueAll();
    }

    /**
     * @param $Id
     *
     * @return bool|TblAccountType
     */
    public function getAccountTypeById($Id)
    {

        return (new Data($this->getBinding()))->getAccountTypeById($Id);
    }

    /**
     * @param $Id
     *
     * @return bool|TblAccountKey
     */
    public function getAccountKeyById($Id)
    {

        return (new Data($this->getBinding()))->getAccountKeyById($Id);
    }

    /**
     * @param $Id
     *
     * @return bool|TblAccountKeyType
     */
    public function getAccountKeyTypeById($Id)
    {

        return (new Data($this->getBinding()))->getAccountKeyTypeById($Id);
    }

    /**
     * @param $Id
     *
     * @return bool|TblAccount
     */
    public function getAccountById($Id)
    {

        return (new Data($this->getBinding()))->getAccountById($Id);
    }

    /**
     * @param bool $IsActive
     *
     * @return bool|TblAccount[]
     */
    public function getAccountAllByActiveState($IsActive = true)
    {

        return (new Data($this->getBinding()))->getAccountAllByActiveState($IsActive);
    }

    /**
     * @param IFormInterface $Stage
     * @param                $Account
     *
     * @return IFormInterface|string
     */
    public function createAccount(IFormInterface &$Stage = null, $Account)
    {

        /**
         * Skip to Frontend
         */
        if (null === $Account) {
            return $Stage;
        }
        $Error = false;
        if (isset( $Account['Description'] ) && empty( $Account['Description'] )) {
            $Stage->setError('Account[Description]', 'Bitte geben sie eine Beschreibung an');
            $Error = true;
        }
        if (isset( $Account['Number'] ) && empty( $Account['Number'] )) {
            $Stage->setError('Account[Number]', 'Bitte geben sie die Nummer an');
            $Error = true;
        }
        $Account['IsActive'] = 1;

        if (!$Error) {
            (new Data($this->getBinding()))->createAccount(
                $Account['Number'],
                $Account['Description'],
                $Account['IsActive'],
                (new Data($this->getBinding()))->getAccountKeyById($Account['Key']),
                (new Data($this->getBinding()))->getAccountTypeById($Account['Type']));
            return new Success('Das Konto ist erfasst worden')
            .new Redirect('/Billing/Accounting/Account', 2);
        }
        return $Stage;
    }

}
