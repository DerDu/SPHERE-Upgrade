<?php
namespace SPHERE\Application\People\Relationship;

use SPHERE\Application\Corporation\Company\Company;
use SPHERE\Application\Corporation\Company\Service\Entity\TblCompany;
use SPHERE\Application\People\Person\Person;
use SPHERE\Application\People\Person\Service\Entity\TblPerson;
use SPHERE\Application\People\Relationship\Service\Data;
use SPHERE\Application\People\Relationship\Service\Entity\TblGroup;
use SPHERE\Application\People\Relationship\Service\Entity\TblToCompany;
use SPHERE\Application\People\Relationship\Service\Entity\TblToPerson;
use SPHERE\Application\People\Relationship\Service\Entity\TblType;
use SPHERE\Application\People\Relationship\Service\Setup;
use SPHERE\Common\Frontend\Form\IFormInterface;
use SPHERE\Common\Frontend\Form\Structure\FormColumn;
use SPHERE\Common\Frontend\Form\Structure\FormGroup;
use SPHERE\Common\Frontend\Form\Structure\FormRow;
use SPHERE\Common\Frontend\Message\Repository\Danger;
use SPHERE\Common\Frontend\Message\Repository\Success;
use SPHERE\Common\Window\Redirect;
use SPHERE\System\Database\Extender\AbstractService;

/**
 * Class Service
 *
 * @package SPHERE\Application\People\Relationship
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

        $Protocol = (new Setup($this->getStructure()))->setupDatabaseSchema($doSimulation);
        if (!$doSimulation && $withData) {
            (new Data($this->getBinding()))->setupDatabaseContent();
        }
        return $Protocol;
    }

    /**
     * @param TblPerson $tblPerson
     *
     * @return bool|TblToPerson[]
     */
    public function getPersonRelationshipAllByPerson(TblPerson $tblPerson)
    {

        return (new Data($this->getBinding()))->getPersonRelationshipAllByPerson($tblPerson);
    }

    /**
     * @param TblPerson $tblPerson
     *
     * @return bool|TblToPerson[]
     */
    public function getCompanyRelationshipAllByPerson(TblPerson $tblPerson)
    {

        return (new Data($this->getBinding()))->getCompanyRelationshipAllByPerson($tblPerson);
    }

    /**
     * @param TblCompany $tblCompany
     *
     * @return bool|TblToCompany[]
     */
    public function getCompanyRelationshipAllByCompany(TblCompany $tblCompany)
    {

        return (new Data($this->getBinding()))->getCompanyRelationshipAllByCompany($tblCompany);
    }

    /**
     * @param IFormInterface $Form
     * @param TblPerson      $tblPersonFrom
     * @param int            $tblPersonTo
     * @param array          $Type
     *
     * @return IFormInterface|string
     */
    public function createRelationshipToPerson(
        IFormInterface $Form,
        TblPerson $tblPersonFrom,
        $tblPersonTo,
        $Type
    ) {

        /**
         * Skip to Frontend
         */
        if (null === $Type) {
            return $Form;
        }

        $Error = false;

        if (empty( $tblPersonTo )) {
            $Form->appendGridGroup(new FormGroup(new FormRow(new FormColumn(new Danger('Bitte wählen Sie eine Person')))));
            $Error = true;
        } else {
            $tblPersonTo = Person::useService()->getPersonById($tblPersonTo);
            if ($tblPersonFrom->getId() == $tblPersonTo->getId()) {
                $Form->appendGridGroup(new FormGroup(new FormRow(new FormColumn(new Danger('Eine Person kann nur mit einer anderen Person verknüpft werden')))));
                $Error = true;
            }
        }

        if (!$Error) {

            $tblType = $this->getTypeById($Type['Type']);

            if ((new Data($this->getBinding()))->addPersonRelationshipToPerson($tblPersonFrom, $tblPersonTo, $tblType,
                $Type['Remark'])
            ) {
                return new Success('Die Beziehung wurde erfolgreich hinzugefügt')
                .new Redirect('/People/Person', 1, array('Id' => $tblPersonFrom->getId()));
            } else {
                return new Danger('Die Beziehung konnte nicht hinzugefügt werden')
                .new Redirect('/People/Person', 10, array('Id' => $tblPersonFrom->getId()));
            }
        }
        return $Form;
    }

    /**
     * @param integer $Id
     *
     * @return bool|TblType
     */
    public function getTypeById($Id)
    {

        return (new Data($this->getBinding()))->getTypeById($Id);
    }

    /**
     * @param TblGroup|null $tblGroup
     *
     * @return bool|TblType[]
     */
    public function getTypeAllByGroup(TblGroup $tblGroup = null)
    {

        return (new Data($this->getBinding()))->getTypeAllByGroup($tblGroup);
    }

    /**
     * @param integer $Id
     *
     * @return bool|TblGroup
     */
    public function getGroupById($Id)
    {

        return (new Data($this->getBinding()))->getGroupById($Id);
    }

    /**
     * @param string $Identifier
     *
     * @return bool|TblGroup
     */
    public function getGroupByIdentifier($Identifier)
    {

        return (new Data($this->getBinding()))->getGroupByIdentifier($Identifier);
    }

    /**
     * @param IFormInterface $Form
     * @param TblPerson      $tblPersonFrom
     * @param int            $tblCompanyTo
     * @param array          $Type
     *
     * @return IFormInterface|string
     */
    public function createRelationshipToCompany(
        IFormInterface $Form,
        TblPerson $tblPersonFrom,
        $tblCompanyTo,
        $Type
    ) {

        /**
         * Skip to Frontend
         */
        if (null === $Type) {
            return $Form;
        }

        $Error = false;

        if (empty( $tblCompanyTo )) {
            $Form->appendGridGroup(new FormGroup(new FormRow(new FormColumn(new Danger('Bitte wählen Sie eine Firma')))));
            $Error = true;
        } else {
            $tblCompanyTo = Company::useService()->getCompanyById($tblCompanyTo);
        }

        if (!$Error) {

            $tblType = $this->getTypeById($Type['Type']);

            if ((new Data($this->getBinding()))->addCompanyRelationshipToPerson($tblCompanyTo, $tblPersonFrom, $tblType,
                $Type['Remark'])
            ) {
                return new Success('Die Beziehung wurde erfolgreich hinzugefügt')
                .new Redirect('/People/Person', 1, array('Id' => $tblPersonFrom->getId()));
            } else {
                return new Danger('Die Beziehung konnte nicht hinzugefügt werden')
                .new Redirect('/People/Person', 10, array('Id' => $tblPersonFrom->getId()));
            }
        }
        return $Form;
    }

    /**
     * @param IFormInterface $Form
     * @param TblToPerson    $tblToPerson
     * @param TblPerson      $tblPersonFrom
     * @param int            $tblPersonTo
     * @param array          $Type
     *
     * @return IFormInterface|string
     */
    public function updateRelationshipToPerson(
        IFormInterface $Form,
        TblToPerson $tblToPerson,
        TblPerson $tblPersonFrom,
        $tblPersonTo,
        $Type
    ) {

        /**
         * Skip to Frontend
         */
        if (null === $Type) {
            return $Form;
        }

        $Error = false;

        if (empty( $tblPersonTo )) {
            $Form->appendGridGroup(new FormGroup(new FormRow(new FormColumn(new Danger('Bitte wählen Sie eine Person')))));
            $Error = true;
        } else {
            $tblPersonTo = Person::useService()->getPersonById($tblPersonTo);
            if ($tblPersonFrom->getId() == $tblPersonTo->getId()) {
                $Form->appendGridGroup(new FormGroup(new FormRow(new FormColumn(new Danger('Eine Person kann nur mit einer anderen Person verknüpft werden')))));
                $Error = true;
            }
        }

        if (!$Error) {
            $tblType = $this->getTypeById($Type['Type']);
            // Remove current
            (new Data($this->getBinding()))->removePersonRelationshipToPerson($tblToPerson);
            // Add new
            if ((new Data($this->getBinding()))->addPersonRelationshipToPerson($tblPersonFrom, $tblPersonTo, $tblType,
                $Type['Remark'])
            ) {
                return new Success('Die Beziehung wurde erfolgreich geändert')
                .new Redirect('/People/Person', 1,
                    array('Id' => $tblToPerson->getServiceTblPersonFrom()->getId()));
            } else {
                return new Danger('Die Beziehung konnte nicht geändert werden')
                .new Redirect('/People/Person', 10,
                    array('Id' => $tblToPerson->getServiceTblPersonFrom()->getId()));
            }
        }
        return $Form;
    }

    /**
     * @param IFormInterface $Form
     * @param TblToCompany   $tblToCompany
     * @param TblPerson      $tblPersonFrom
     * @param int            $tblCompanyTo
     * @param array          $Type
     *
     * @return IFormInterface|string
     */
    public function updateRelationshipToCompany(
        IFormInterface $Form,
        TblToCompany $tblToCompany,
        TblPerson $tblPersonFrom,
        $tblCompanyTo,
        $Type
    ) {

        /**
         * Skip to Frontend
         */
        if (null === $Type) {
            return $Form;
        }

        $Error = false;

        if (empty( $tblCompanyTo )) {
            $Form->appendGridGroup(new FormGroup(new FormRow(new FormColumn(new Danger('Bitte wählen Sie eine Firma')))));
            $Error = true;
        } else {
            $tblCompanyTo = Company::useService()->getCompanyById($tblCompanyTo);
        }

        if (!$Error) {
            $tblType = $this->getTypeById($Type['Type']);
            // Remove current
            (new Data($this->getBinding()))->removeCompanyRelationshipToPerson($tblToCompany);
            // Add new
            if ((new Data($this->getBinding()))->addCompanyRelationshipToPerson($tblCompanyTo, $tblPersonFrom, $tblType,
                $Type['Remark'])
            ) {
                return new Success('Die Beziehung wurde erfolgreich geändert')
                .new Redirect('/People/Person', 1,
                    array('Id' => $tblToCompany->getServiceTblPerson()->getId()));
            } else {
                return new Danger('Die Beziehung konnte nicht geändert werden')
                .new Redirect('/People/Person', 10,
                    array('Id' => $tblToCompany->getServiceTblPerson()->getId()));
            }
        }
        return $Form;
    }

    /**
     * @return bool|TblType[]
     */
    public function getTypeAll()
    {

        return (new Data($this->getBinding()))->getTypeAll();
    }

    /**
     * @param TblToPerson $tblToPerson
     *
     * @return bool
     */
    public function removePersonRelationshipToPerson(TblToPerson $tblToPerson)
    {

        return (new Data($this->getBinding()))->removePersonRelationshipToPerson($tblToPerson);
    }

    /**
     * @param TblToCompany $tblToCompany
     *
     * @return bool
     */
    public function removeCompanyRelationshipToPerson(TblToCompany $tblToCompany)
    {

        return (new Data($this->getBinding()))->removeCompanyRelationshipToPerson($tblToCompany);
    }

    /**
     * @param integer $Id
     *
     * @return bool|TblToPerson
     */
    public function getRelationshipToPersonById($Id)
    {

        return (new Data($this->getBinding()))->getRelationshipToPersonById($Id);
    }

    /**
     * @param integer $Id
     *
     * @return bool|TblToCompany
     */
    public function getRelationshipToCompanyById($Id)
    {

        return (new Data($this->getBinding()))->getRelationshipToCompanyById($Id);
    }

    /**
     * @param TblPerson $tblPersonFrom
     * @param TblPerson $tblPersonTo
     * @param TblType   $tblType
     * @param string    $Remark
     *
     * @return bool
     */
    public function insertRelationshipToPerson(
        TblPerson $tblPersonFrom,
        TblPerson $tblPersonTo,
        TblType $tblType,
        $Remark
    ) {

        if ((new Data($this->getBinding()))->addPersonRelationshipToPerson($tblPersonFrom, $tblPersonTo, $tblType,
            $Remark)
        ) {
            return true;
        } else {
            return false;
        }
    }
}
