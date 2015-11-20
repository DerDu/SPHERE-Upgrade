<?php
namespace SPHERE\Application\People\Meta\Student\Service\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use SPHERE\Application\Education\Lesson\Subject\Service\Entity\TblSubject;
use SPHERE\Application\Education\Lesson\Subject\Subject;
use SPHERE\Application\People\Meta\Student\Student;
use SPHERE\System\Database\Extender\AbstractEntity;

/**
 * @Entity
 * @Table(name="tblStudentSubject")
 * @Cache(usage="READ_ONLY")
 */
class TblStudentSubject extends AbstractEntity
{

    const ATTR_TBL_STUDENT = 'tblStudent';
    const ATTR_TBL_STUDENT_SUBJECT_TYPE = 'tblStudentSubjectType';
    const ATTR_TBL_STUDENT_SUBJECT_RANKING = 'tblStudentSubjectRanking';
    const SERVICE_TBL_SUBJECT = 'serviceTblSubject';

    /**
     * @Column(type="bigint")
     */
    protected $tblStudent;
    /**
     * @Column(type="bigint")
     */
    protected $tblStudentSubjectType;
    /**
     * @Column(type="bigint")
     */
    protected $tblStudentSubjectRanking;
    /**
     * @Column(type="bigint")
     */
    protected $serviceTblSubject;

    /**
     * @return bool|TblStudent
     */
    public function getTblStudent()
    {

        if (null === $this->tblStudent) {
            return false;
        } else {
            return Student::useService()->getStudentById($this->tblStudent);
        }
    }

    /**
     * @param null|TblStudent $tblStudent
     */
    public function setTblStudent(TblStudent $tblStudent = null)
    {

        $this->tblStudent = ( null === $tblStudent ? null : $tblStudent->getId() );
    }

    /**
     * @return bool|TblStudentSubjectType
     */
    public function getTblStudentSubjectType()
    {

        if (null === $this->tblStudentSubjectType) {
            return false;
        } else {
            return Student::useService()->getStudentSubjectTypeById($this->tblStudentSubjectType);
        }
    }

    /**
     * @param null|TblStudentSubjectType $tblStudentSubjectType
     */
    public function setTblStudentSubjectType(TblStudentSubjectType $tblStudentSubjectType = null)
    {

        $this->tblStudentSubjectType = ( null === $tblStudentSubjectType ? null : $tblStudentSubjectType->getId() );
    }

    /**
     * @return bool|TblStudentSubjectRanking
     */
    public function getTblStudentSubjectRanking()
    {

        if (null === $this->tblStudentSubjectRanking) {
            return false;
        } else {
            return Student::useService()->getStudentSubjectRankingById($this->tblStudentSubjectRanking);
        }
    }

    /**
     * @param null|TblStudentSubjectRanking $tblStudentSubjectRanking
     */
    public function setTblStudentSubjectRanking(TblStudentSubjectRanking $tblStudentSubjectRanking = null)
    {

        $this->tblStudentSubjectRanking = ( null === $tblStudentSubjectRanking ? null : $tblStudentSubjectRanking->getId() );
    }

    /**
     * @return bool|TblSubject
     */
    public function getServiceTblSubject()
    {

        if (null === $this->serviceTblSubject) {
            return false;
        } else {
            return Subject::useService()->getSubjectById($this->serviceTblSubject);
        }
    }

    /**
     * @param TblSubject|null $tblSubject
     */
    public function setServiceTblSubject(TblSubject $tblSubject = null)
    {

        $this->serviceTblSubject = ( null === $tblSubject ? null : $tblSubject->getId() );
    }
}
