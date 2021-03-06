<?php

namespace Ilios\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Ilios\CoreBundle\Traits\TitledEntity;
use Ilios\CoreBundle\Traits\CoursesEntity;
use Ilios\CoreBundle\Traits\ProgramsEntity;
use Ilios\CoreBundle\Traits\DeletableEntity;

/**
 * Class School
 * @package Ilios\CoreBundle\Entity
 *
 * @ORM\Table(name="school",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="template_prefix", columns={"template_prefix"})
 *   }
 * )
 * @ORM\Entity(repositoryClass="Ilios\CoreBundle\Entity\Repository\SchoolRepository")
 *
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessType("public_method")
 */
class School implements SchoolInterface
{
    use TitledEntity;
    use CoursesEntity;
    use ProgramsEntity;
    use DeletableEntity;

    /**
     * @deprecated Replace with Trait in 3.xf
     * @var int
     *
     * @ORM\Column(name="school_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Assert\Type(type="integer")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 60
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="template_prefix", type="string", length=8, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 8
     * )
     */
    protected $templatePrefix;

    /**
     * @var string
     *
     * @ORM\Column(name="ilios_administrator_email", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 100
     * )
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("iliosAdministratorEmail")
     */
    protected $iliosAdministratorEmail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     *
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     *
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $deleted;

    /**
     * @todo: Normalize later. Collection of email addresses. (Add email entity, etc)
     * @var string
     *
     * @ORM\Column(name="change_alert_recipients", type="text", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("changeAlertRecipients")
     */
    protected $changeAlertRecipients;

    /**
     * @var ArrayCollection|AlertInterface[]
     *
     * @ORM\ManyToMany(targetEntity="Alert", mappedBy="recipients")
     *
     * @JMS\Expose
     * @JMS\Type("array<string>")
     */
    protected $alerts;

    /**
     * @var ArrayCollection|CompetencyInterface[]
     *
     * @ORM\OneToMany(targetEntity="Competency", mappedBy="school")
     *
     * @JMS\Expose
     * @JMS\Type("array<string>")
     */
    protected $competencies;

    /**
     * @var ArrayCollection|CourseInterface[]
     *
     * @ORM\OneToMany(targetEntity="Course", mappedBy="school")
     *
     * @JMS\Expose
     * @JMS\Type("array<string>")
     */
    protected $courses;

    /**
     * @var ArrayCollection|ProgramInterface[]
     *
     * @ORM\OneToMany(targetEntity="Program", mappedBy="school")
     *
     * @JMS\Expose
     * @JMS\Type("array<string>")
     */
    protected $programs;

    /**
     * @var ArrayCollection|DepartmentInterface[]
     *
     * @ORM\OneToMany(targetEntity="Department", mappedBy="school")
     *
     * @JMS\Expose
     * @JMS\Type("array<string>")
     */
    protected $departments;

    /**
     * @var ArrayCollection|TopicInterface[]
     *
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="school")
     *
     * @JMS\Expose
     * @JMS\Type("array<string>")
     */
    protected $topics;

    /**
    * @var ArrayCollection|InstructorGroupInterface[]
    *
    * @ORM\OneToMany(targetEntity="InstructorGroup", mappedBy="school")
    *
    * @JMS\Expose
    * @JMS\Type("array<string>")
    * @JMS\SerializedName("instructorGroups")
    */
    protected $instructorGroups;

    /**
    * @var CurriculumInventoryInstitutionInterface
    *
    * @ORM\OneToOne(targetEntity="CurriculumInventoryInstitution", mappedBy="school")
    *
    * @JMS\Expose
    * @JMS\Type("string")
    *
    * @JMS\Expose
    * @JMS\Type("string")
    * @JMS\SerializedName("curriculumInventoryInstitution")
    */
    protected $curriculumInventoryInstitution;

    /**
    * @var ArrayCollection|SessionTypeInterface[]
    *
    * @ORM\OneToMany(targetEntity="SessionType", mappedBy="school")
    *
    * @JMS\Expose
    * @JMS\Type("array<string>")
    * @JMS\SerializedName("sessionTypes")
    */
    protected $sessionTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alerts = new ArrayCollection();
        $this->competencies = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->programs = new ArrayCollection();
        $this->deleted = false;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->schoolId = $id;
        $this->id = $id;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return ($this->id === null) ? $this->schoolId : $this->id;
    }

    /**
     * @param string $templatePrefix
     */
    public function setTemplatePrefix($templatePrefix)
    {
        $this->templatePrefix = $templatePrefix;
    }

    /**
     * @return string
     */
    public function getTemplatePrefix()
    {
        return $this->templatePrefix;
    }

    /**
     * @param string $iliosAdministratorEmail
     */
    public function setIliosAdministratorEmail($iliosAdministratorEmail)
    {
        $this->iliosAdministratorEmail = $iliosAdministratorEmail;
    }

    /**
     * @return string
     */
    public function getIliosAdministratorEmail()
    {
        return $this->iliosAdministratorEmail;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        foreach ($this->getDepartments() as $department) {
            $department->setDeleted($deleted);
        }
    }

    /**
     * @param string $changeAlertRecipients
     */
    public function setChangeAlertRecipients($changeAlertRecipients)
    {
        $this->changeAlertRecipients = $changeAlertRecipients;
    }

    /**
     * @return string
     */
    public function getChangeAlertRecipients()
    {
        return $this->changeAlertRecipients;
    }
    
    /**
     * @param string $curriculumInventoryInstitution
     */
    public function setCurriculumInventoryInstitution($curriculumInventoryInstitution)
    {
        $this->curriculumInventoryInstitution = $curriculumInventoryInstitution;
    }

    /**
     * @return string
     */
    public function getCurriculumInventoryInstitution()
    {
        return $this->curriculumInventoryInstitution;
    }

    /**
     * @param Collection $alerts
     */
    public function setAlerts(Collection $alerts)
    {
        $this->alerts = new ArrayCollection();

        foreach ($alerts as $alert) {
            $this->addAlert($alert);
        }
    }

    /**
     * @param AlertInterface $alert
     */
    public function addAlert(AlertInterface $alert)
    {
        $this->alerts->add($alert);
    }

    /**
     * @return ArrayCollection|AlertInterface[]
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @param Collection $competencies
     */
    public function setCompetencies(Collection $competencies)
    {
        $this->competencies = new ArrayCollection();

        foreach ($competencies as $competency) {
            $this->addCompetency($competency);
        }

    }

    /**
     * @param CompetencyInterface $competency
     */
    public function addCompetency(CompetencyInterface $competency)
    {
        $this->competencies->add($competency);
    }

    /**
     * @return ArrayCollection|CompetencyInterface[]
     */
    public function getCompetencies()
    {
        return $this->competencies;
    }

    /**
     * @param Collection $departments
     */
    public function setDepartments(Collection $departments)
    {
        $this->departments = new ArrayCollection();

        foreach ($departments as $department) {
            $this->addDepartment($department);
        }

    }

    /**
     * @param DepartmentInterface $department
     */
    public function addDepartment(DepartmentInterface $department)
    {
        $this->departments->add($department);
    }

    /**
     * @return ArrayCollection|DepartmentInterface[]
     */
    public function getDepartments()
    {
        //criteria not 100% reliale on many to many relationships
        //fix in https://github.com/doctrine/doctrine2/pull/1399
        // $criteria = Criteria::create()->where(Criteria::expr()->eq("deleted", false));
        // return new ArrayCollection($this->departments->matching($criteria)->getValues());
        
        $arr = $this->departments->filter(function ($entity) {
            return !$entity->isDeleted();
        })->toArray();
        
        $reIndexed = array_values($arr);
        
        return new ArrayCollection($reIndexed);
    }

    /**
     * @param Collection $topics
     */
    public function setTopics(Collection $topics)
    {
        $this->topics = new ArrayCollection();

        foreach ($topics as $topic) {
            $this->addTopic($topic);
        }
    }

    /**
     * @param TopicInterface $topic
     */
    public function addTopic(TopicInterface $topic)
    {
        $this->topics->add($topic);
    }

    /**
     * @return ArrayCollection|TopicInterface[]
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * @param Collection $instructorGroups
     */
    public function setInstructorGroups(Collection $instructorGroups)
    {
        $this->instructorGroups = new ArrayCollection();

        foreach ($instructorGroups as $instructorGroup) {
            $this->addInstructorGroup($instructorGroup);
        }
    }

    /**
     * @param InstructorGroupInterface $instructorGroup
     */
    public function addInstructorGroup(InstructorGroupInterface $instructorGroup)
    {
        $this->instructorGroups->add($instructorGroup);
    }

    /**
     * @return ArrayCollection|InstructorGroupInterface[]
     */
    public function getInstructorGroups()
    {
        return $this->instructorGroups;
    }

    /**
     * @param Collection $sessionTypes
     */
    public function setSessionTypes(Collection $sessionTypes)
    {
        $this->sessionTypes = new ArrayCollection();

        foreach ($sessionTypes as $sessionType) {
            $this->addSessionType($sessionType);
        }
    }

    /**
     * @param SessionTypeInterface $sessionType
     */
    public function addSessionType(SessionTypeInterface $sessionType)
    {
        $this->sessionTypes->add($sessionType);
    }

    /**
     * @return ArrayCollection|SessionTypeInterface[]
     */
    public function getSessionTypes()
    {
        return $this->sessionTypes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->id;
    }
}
