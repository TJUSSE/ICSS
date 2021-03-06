<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity
 */
class Student extends BaseUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="card_id", type="string", length=32, unique=true, nullable=true)
     */
    private $cardId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="grade", type="integer", nullable=true)
     */
    private $grade;

    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", length=64, nullable=true)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="major", type="string", length=64, nullable=true)
     */
    private $major;

    /**
     * @var string
     *
     * @ORM\Column(name="identity", type="string", length=32, nullable=true)
     */
    private $identity;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=32, nullable=true)
     */
    private $mobile;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean", nullable=true)
     */
    private $valid;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \SSE\ICSSBundle\Entity\Teacher
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Teacher")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mentor_teacher_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $mentor;

    /**
     * @var \SSE\ICSSBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $project;

    /**
     * @var \SSE\ICSSBundle\Entity\Gender
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Gender")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gender_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $gender;

    /**
     * @var \SSE\ICSSBundle\Entity\Direction
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Direction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="direction_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $direction;

    public function __construct()
    {
        $this->setEnabled(true);
        $this->setValid(true);
        $this->setRoles('ROLE_STUDENT');
    }

    /**
     * Set cardId
     *
     * @param string $cardId
     * @return Student
     */

    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId
     *
     * @return string
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Student
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     * @return Student
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return Student
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set major
     *
     * @param string $major
     * @return Student
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get major
     *
     * @return string
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set identity
     *
     * @param string $identity
     * @return Student
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return Student
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     * @return Student
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mentor
     *
     * @param \SSE\ICSSBundle\Entity\Teacher $mentor
     * @return Student
     */
    public function setMentor(\SSE\ICSSBundle\Entity\Teacher $mentor = null)
    {
        $this->mentor = $mentor;

        return $this;
    }

    /**
     * Get mentor
     *
     * @return \SSE\ICSSBundle\Entity\Teacher
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * Set project
     *
     * @param \SSE\ICSSBundle\Entity\Project $project
     * @return Student
     */
    public function setProject(\SSE\ICSSBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \SSE\ICSSBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set gender
     *
     * @param \SSE\ICSSBundle\Entity\Gender $gender
     * @return Student
     */
    public function setGender(\SSE\ICSSBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \SSE\ICSSBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set direction
     *
     * @param \SSE\ICSSBundle\Entity\Direction $direction
     * @return Student
     */
    public function setDirection(\SSE\ICSSBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \SSE\ICSSBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    public function __toString()
    {
        return $this->getName() ?: '学生';
    }
}
