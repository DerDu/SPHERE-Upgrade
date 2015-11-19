<?php
namespace SPHERE\Application\People\Person;

use SPHERE\Application\People\Group\Group;
use SPHERE\Application\People\Group\Service\Entity\TblGroup;
use SPHERE\Application\People\Person\Service\Data;
use SPHERE\Application\People\Person\Service\Entity\TblPerson;
use SPHERE\Application\People\Person\Service\Entity\TblSalutation;
use SPHERE\Application\People\Person\Service\Setup;
use SPHERE\Common\Frontend\Form\IFormInterface;
use SPHERE\Common\Frontend\Message\Repository\Danger;
use SPHERE\Common\Frontend\Message\Repository\Success;
use SPHERE\Common\Window\Redirect;
use SPHERE\System\Database\Binding\AbstractService;

/**
 * Class Service
 *
 * @package SPHERE\Application\People\Person
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
     * @return bool|TblSalutation[]
     */
    public function getSalutationAll()
    {

        return (new Data($this->getBinding()))->getSalutationAll();
    }

    /**
     * int
     */
    public function countPersonAll()
    {

        return (new Data($this->getBinding()))->countPersonAll();
    }

    /**
     * @return bool|TblPerson[]
     */
    public function getPersonAll()
    {

        return (new Data($this->getBinding()))->getPersonAll();
    }

    /**
     * @param TblGroup $tblGroup
     *
     * @return int
     */
    public function countPersonAllByGroup(TblGroup $tblGroup)
    {

        return Group::useService()->countPersonAllByGroup($tblGroup);
    }

    /**
     * @param IFormInterface $Form
     * @param array $Person
     *
     * @return IFormInterface|Redirect
     */
    public function createPerson(IFormInterface $Form = null, $Person)
    {

        /**
         * Skip to Frontend
         */
        if (null === $Person) {
            return $Form;
        }

        $Error = false;

        if (isset($Person['FirstName']) && empty($Person['FirstName'])) {
            $Form->setError('Person[FirstName]', 'Bitte geben Sie einen Vornamen an');
            $Error = true;
        }
        if (isset($Person['LastName']) && empty($Person['LastName'])) {
            $Form->setError('Person[LastName]', 'Bitte geben Sie einen Nachnamen an');
            $Error = true;
        }

        if (!$Error) {

            if (($tblPerson = (new Data($this->getBinding()))->createPerson(
                $this->getSalutationById($Person['Salutation']), $Person['Title'], $Person['FirstName'],
                $Person['SecondName'], $Person['LastName'], $Person['BirthName']))
            ) {
                // Add to Group
                if (isset($Person['Group'])) {
                    foreach ((array)$Person['Group'] as $tblGroup) {
                        Group::useService()->addGroupPerson(
                            Group::useService()->getGroupById($tblGroup), $tblPerson
                        );
                    }
                }
                return new Success('Die Person wurde erfolgreich erstellt')
                . new Redirect('/People/Person', 1,
                    array('Id' => $tblPerson->getId())
                );
            } else {
                return new Danger('Die Person konnte nicht erstellt werden')
                . new Redirect('/People/Person', 10);
            }
        }

        return $Form;
    }

    /**
     * @param int $Id
     *
     * @return bool|TblSalutation
     */
    public function getSalutationById($Id)
    {

        return (new Data($this->getBinding()))->getSalutationById($Id);
    }

    /**
     * @param $Salutation
     * @param $Title
     * @param $FirstName
     * @param $SecondName
     * @param $LastName
     * @param $GroupList
     *
     * @return bool|TblPerson
     */
    public function insertPerson($Salutation, $Title, $FirstName, $SecondName, $LastName, $GroupList)
    {

        if (($tblPerson = (new Data($this->getBinding()))->createPerson(
            $Salutation, $Title, $FirstName, $SecondName, $LastName))
        ) {
            // Add to Group
            if (!empty($GroupList)) {
                foreach ($GroupList as $tblGroup) {
                    Group::useService()->addGroupPerson(
                        Group::useService()->getGroupById($tblGroup), $tblPerson
                    );
                }
            }
            return $tblPerson;
        } else {
            return false;
        }
    }

    /**
     * @param integer $Id
     *
     * @return bool|TblPerson
     */
    public function getPersonById($Id)
    {

        return (new Data($this->getBinding()))->getPersonById($Id);
    }

    /**
     * @param IFormInterface $Form
     * @param TblPerson $tblPerson
     * @param array $Person
     * @param null|int $Group
     *
     * @return IFormInterface|Redirect
     */
    public function updatePerson(IFormInterface $Form = null, TblPerson $tblPerson, $Person, $Group)
    {

        /**
         * Skip to Frontend
         */
        if (null === $Person) {
            return $Form;
        }

        $Error = false;

        if (isset($Person['FirstName']) && empty($Person['FirstName'])) {
            $Form->setError('Person[FirstName]', 'Bitte geben Sie einen Vornamen an');
            $Error = true;
        }
        if (isset($Person['LastName']) && empty($Person['LastName'])) {
            $Form->setError('Person[LastName]', 'Bitte geben Sie einen Nachnamen an');
            $Error = true;
        }

        if (!$Error) {

            if ((new Data($this->getBinding()))->updatePerson($tblPerson, $Person['Salutation'], $Person['Title'],
                $Person['FirstName'], $Person['SecondName'], $Person['LastName'], $Person['BirthName'])
            ) {
                // Change Groups
                if (isset($Person['Group'])) {
                    // Remove all Groups
                    $tblGroupList = Group::useService()->getGroupAllByPerson($tblPerson);
                    foreach ($tblGroupList as $tblGroup) {
                        Group::useService()->removeGroupPerson($tblGroup, $tblPerson);
                    }
                    // Add current Groups
                    foreach ((array)$Person['Group'] as $tblGroup) {
                        Group::useService()->addGroupPerson(
                            Group::useService()->getGroupById($tblGroup), $tblPerson
                        );
                    }
                } else {
                    // Remove all Groups
                    $tblGroupList = Group::useService()->getGroupAllByPerson($tblPerson);
                    foreach ($tblGroupList as $tblGroup) {
                        Group::useService()->removeGroupPerson($tblGroup, $tblPerson);
                    }
                }
                return new Success('Die Person wurde erfolgreich aktualisiert')
                . new Redirect('/People/Person', 1,
                    array('Id' => $tblPerson->getId(), 'Group' => $Group)
                );
            } else {
                return new Danger('Die Person konnte nicht aktualisiert werden')
                . new Redirect('/People/Person', 10);
            }
        }

        return $Form;
    }
}
