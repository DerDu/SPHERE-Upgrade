<?php
namespace SPHERE\Application\People\Meta\Student\Service;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use SPHERE\System\Database\Binding\AbstractSetup;

/**
 * Class Setup
 *
 * @package SPHERE\Application\People\Meta\Student\Service
 */
class Setup extends AbstractSetup
{

    /**
     * @param bool $Simulate
     *
     * @return string
     */
    public function setupDatabaseSchema($Simulate = true)
    {

        /**
         * Table
         */
        $Schema = clone $this->getConnection()->getSchema();
        $tblStudentMedicalRecord = $this->setTableStudentMedicalRecord($Schema);
        $tblStudentTransport = $this->setTableStudentTransport($Schema);
        $tblStudentBilling = $this->setTableStudentBilling($Schema);
        $tblStudentLocker = $this->setTableStudentLocker($Schema);
        $tblStudentBaptism = $this->setTableStudentBaptism($Schema);
        $tblStudentIntegration = $this->setTableStudentIntegration($Schema);

        $tblStudent = $this->setTableStudent(
            $Schema, $tblStudentMedicalRecord, $tblStudentTransport,
            $tblStudentBilling, $tblStudentLocker, $tblStudentBaptism, $tblStudentIntegration
        );

        $tblStudentTransferType = $this->setTableStudentTransferType($Schema);
        $this->setTableStudentTransfer($Schema, $tblStudent, $tblStudentTransferType);

        $tblStudentAgreementCategory = $this->setTableStudentAgreementCategory($Schema);
        $tblStudentAgreementType = $this->setTableStudentAgreementType($Schema, $tblStudentAgreementCategory);
        $this->setTableStudentAgreement($Schema, $tblStudent, $tblStudentAgreementType);

        $tblStudentSubjectType = $this->setTableStudentSubjectType($Schema);
        $tblStudentSubjectRanking = $this->setTableStudentSubjectRanking($Schema);
        $this->setTableStudentSubject($Schema, $tblStudent, $tblStudentSubjectType, $tblStudentSubjectRanking);

        $tblStudentDisorderType = $this->setTableStudentDisorderType($Schema);
        $this->setTableStudentDisorder($Schema, $tblStudent, $tblStudentDisorderType);

        $tblStudentFocusType = $this->setTableStudentFocusType($Schema);
        $this->setTableStudentFocus($Schema, $tblStudent, $tblStudentFocusType);

        /**
         * Migration & Protocol
         */
        $this->getConnection()->addProtocol(__CLASS__);
        $this->getConnection()->setMigration($Schema, $Simulate);
        return $this->getConnection()->getProtocol($Simulate);
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentMedicalRecord(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentMedicalRecord');
        if (!$this->getConnection()->hasColumn('tblStudentMedicalRecord', 'Disease')) {
            $Table->addColumn('Disease', 'text');
        }
        if (!$this->getConnection()->hasColumn('tblStudentMedicalRecord', 'Medication')) {
            $Table->addColumn('Medication', 'text');
        }
        if (!$this->getConnection()->hasColumn('tblStudentMedicalRecord', 'serviceTblPersonAttendingDoctor')) {
            $Table->addColumn('serviceTblPersonAttendingDoctor', 'bigint', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentMedicalRecord', 'InsuranceState')) {
            $Table->addColumn('InsuranceState', 'bigint');
        }
        if (!$this->getConnection()->hasColumn('tblStudentMedicalRecord', 'Insurance')) {
            $Table->addColumn('Insurance', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentTransport(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentTransport');
        if (!$this->getConnection()->hasColumn('tblStudentTransport', 'Route')) {
            $Table->addColumn('Route', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentTransport', 'StationEntrance')) {
            $Table->addColumn('StationEntrance', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentTransport', 'StationExit')) {
            $Table->addColumn('StationExit', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentTransport', 'Remark')) {
            $Table->addColumn('Remark', 'text');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentBilling(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentBilling');
        if (!$this->getConnection()->hasColumn('tblStudentBilling', 'serviceTblSiblingRank')) {
            $Table->addColumn('serviceTblSiblingRank', 'bigint', array('notnull' => false));
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentLocker(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentLocker');
        if (!$this->getConnection()->hasColumn('tblStudentLocker', 'LockerNumber')) {
            $Table->addColumn('LockerNumber', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentLocker', 'LockerLockation')) {
            $Table->addColumn('LockerLockation', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentLocker', 'KeyNumber')) {
            $Table->addColumn('KeyNumber', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentBaptism(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentBaptism');
        if (!$this->getConnection()->hasColumn('tblStudentBaptism', 'BaptismDate')) {
            $Table->addColumn('BaptismDate', 'datetime', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentBaptism', 'Location')) {
            $Table->addColumn('Location', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentIntegration(
        Schema &$Schema
    ) {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentIntegration');
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'serviceTblPerson')) {
            $Table->addColumn('serviceTblPerson', 'bigint', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'serviceTblCompany')) {
            $Table->addColumn('serviceTblCompany', 'bigint', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'CoachingRequestDate')) {
            $Table->addColumn('CoachingRequestDate', 'datetime', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'CoachingCounselDate')) {
            $Table->addColumn('CoachingCounselDate', 'datetime', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'CoachingDecisionDate')) {
            $Table->addColumn('CoachingDecisionDate', 'datetime', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'CoachingRequired')) {
            $Table->addColumn('CoachingRequired', 'boolean', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'CoachingTime')) {
            $Table->addColumn('CoachingTime', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentIntegration', 'CoachingRemark')) {
            $Table->addColumn('CoachingRemark', 'text');
        }
        return $Table;
    }

    /**
     * @param Schema                             $Schema
     * @param Table  $tblStudentMedicalRecord
     * @param Table  $tblStudentTransport
     * @param Table  $tblStudentBilling
     * @param Table  $tblStudentLocker
     * @param Table  $tblStudentBaptism
     * @param Table                              $tblStudentIntegration
     *
     * @return Table
     */
    private function setTableStudent(
        Schema &$Schema,
        Table $tblStudentMedicalRecord,
        Table $tblStudentTransport,
        Table $tblStudentBilling,
        Table $tblStudentLocker,
        Table $tblStudentBaptism,
        Table $tblStudentIntegration
    ) {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudent');
        if (!$this->getConnection()->hasColumn('tblStudent', 'serviceTblPerson')) {
            $Table->addColumn('serviceTblPerson', 'bigint', array('notnull' => false));
        }
        $this->getConnection()->addForeignKey($Table, $tblStudentMedicalRecord);
        $this->getConnection()->addForeignKey($Table, $tblStudentTransport);
        $this->getConnection()->addForeignKey($Table, $tblStudentBilling);
        $this->getConnection()->addForeignKey($Table, $tblStudentLocker);
        $this->getConnection()->addForeignKey($Table, $tblStudentBaptism);
        $this->getConnection()->addForeignKey($Table, $tblStudentIntegration);
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentTransferType(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentTransferType');
        if (!$this->getConnection()->hasColumn('tblStudentTransferType', 'Identifier')) {
            $Table->addColumn('Identifier', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentTransferType', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblStudent
     * @param Table  $tblStudentTransferType
     *
     * @return Table
     */
    private function setTableStudentTransfer(
        Schema &$Schema,
        Table $tblStudent,
        Table $tblStudentTransferType
    ) {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentTransfer');
        if (!$this->getConnection()->hasColumn('tblStudentTransfer', 'serviceTblCompany')) {
            $Table->addColumn('serviceTblCompany', 'bigint', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentTransfer', 'serviceTblType')) {
            $Table->addColumn('serviceTblType', 'bigint', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentTransfer', 'TransferDate')) {
            $Table->addColumn('TransferDate', 'datetime', array('notnull' => false));
        }
        if (!$this->getConnection()->hasColumn('tblStudentTransfer', 'Remark')) {
            $Table->addColumn('Remark', 'text');
        }
        $this->getConnection()->addForeignKey($Table, $tblStudent);
        $this->getConnection()->addForeignKey($Table, $tblStudentTransferType);
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentAgreementCategory(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentAgreementCategory');
        if (!$this->getConnection()->hasColumn('tblStudentAgreementCategory', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentAgreementCategory', 'Description')) {
            $Table->addColumn('Description', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblStudentAgreementCategory
     *
     * @return Table
     */
    private function setTableStudentAgreementType(Schema &$Schema, Table $tblStudentAgreementCategory)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentAgreementType');
        if (!$this->getConnection()->hasColumn('tblStudentAgreementType', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentAgreementType', 'Description')) {
            $Table->addColumn('Description', 'string');
        }
        $this->getConnection()->addForeignKey($Table, $tblStudentAgreementCategory);
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblStudent
     * @param Table  $tblStudentAgreementType
     *
     * @return Table
     */
    private function setTableStudentAgreement(
        Schema &$Schema,
        Table $tblStudent,
        Table $tblStudentAgreementType
    ) {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentAgreement');
        $this->getConnection()->addForeignKey($Table, $tblStudent);
        $this->getConnection()->addForeignKey($Table, $tblStudentAgreementType);
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentSubjectType(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentSubjectType');
        if (!$this->getConnection()->hasColumn('tblStudentSubjectType', 'Identifier')) {
            $Table->addColumn('Identifier', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentSubjectType', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentSubjectRanking(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentSubjectRanking');
        if (!$this->getConnection()->hasColumn('tblStudentSubjectRanking', 'Identifier')) {
            $Table->addColumn('Identifier', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentSubjectRanking', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblStudent
     * @param Table  $tblStudentSubjectType
     * @param Table  $tblStudentSubjectRanking
     *
     * @return Table
     */
    private function setTableStudentSubject(
        Schema &$Schema,
        Table $tblStudent,
        Table $tblStudentSubjectType,
        Table $tblStudentSubjectRanking
    ) {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentSubject');
        $this->getConnection()->addForeignKey($Table, $tblStudent);
        $this->getConnection()->addForeignKey($Table, $tblStudentSubjectType);
        $this->getConnection()->addForeignKey($Table, $tblStudentSubjectRanking);
        if (!$this->getConnection()->hasColumn('tblStudentSubject', 'serviceTblSubject')) {
            $Table->addColumn('serviceTblSubject', 'bigint', array('notnull' => false));
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentDisorderType(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentDisorderType');
        if (!$this->getConnection()->hasColumn('tblStudentDisorderType', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentDisorderType', 'Description')) {
            $Table->addColumn('Description', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblStudent
     * @param Table  $tblStudentDisorderType
     *
     * @return Table
     */
    private function setTableStudentDisorder(
        Schema &$Schema,
        Table $tblStudent,
        Table $tblStudentDisorderType
    ) {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentDisorder');
        $this->getConnection()->addForeignKey($Table, $tblStudent);
        $this->getConnection()->addForeignKey($Table, $tblStudentDisorderType);
        return $Table;
    }

    /**
     * @param Schema $Schema
     *
     * @return Table
     */
    private function setTableStudentFocusType(Schema &$Schema)
    {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentFocusType');
        if (!$this->getConnection()->hasColumn('tblStudentFocusType', 'Name')) {
            $Table->addColumn('Name', 'string');
        }
        if (!$this->getConnection()->hasColumn('tblStudentFocusType', 'Description')) {
            $Table->addColumn('Description', 'string');
        }
        return $Table;
    }

    /**
     * @param Schema $Schema
     * @param Table  $tblStudent
     * @param Table  $tblStudentFocusType
     *
     * @return Table
     */
    private function setTableStudentFocus(
        Schema &$Schema,
        Table $tblStudent,
        Table $tblStudentFocusType
    ) {

        $Table = $this->getConnection()->createTable($Schema, 'tblStudentFocus');
        $this->getConnection()->addForeignKey($Table, $tblStudent);
        $this->getConnection()->addForeignKey($Table, $tblStudentFocusType);
        return $Table;
    }

}
