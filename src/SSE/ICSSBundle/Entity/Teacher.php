<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 *
 * @ORM\Table(name="teacher")
 * @ORM\Entity
 */
class Teacher extends BaseUser
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
     * @var string
     *
     * @ORM\Column(name="office_name", type="string", length=64, nullable=true)
     */
    private $officeName;

    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", length=64, nullable=true)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="office", type="string", length=64, nullable=true)
     */
    private $office;

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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * @var \SSE\ICSSBundle\Entity\Gender
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Gender")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gender_id", referencedColumnName="id")
     * })
     */
    private $gender;
   
    public function __construct()
    {
        $this->setRoles('ROLE_TEACHER');
    }

    /**
     * Set cardId
     *
     * @param string $cardId
     * @return Teacher
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
     * @return Teacher
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
     * Set officeName
     *
     * @param string $officeName
     * @return Teacher
     */
    public function setOfficeName($officeName)
    {
        $this->officeName = $officeName;

        return $this;
    }

    /**
     * Get officeName
     *
     * @return string
     */
    public function getOfficeName()
    {
        return $this->officeName;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return Teacher
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
     * Set office
     *
     * @param string $office
     * @return Teacher
     */
    public function setOffice($office)
    {
        $this->office = $office;

        return $this;
    }

    /**
     * Get office
     *
     * @return string
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * Set identity
     *
     * @param string $identity
     * @return Teacher
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
     * @return Teacher
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
     * @return Teacher
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gender
     *
     * @param \SSE\ICSSBundle\Entity\Gender $gender
     * @return Teacher
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

    public function __toString()
    {
        return $this->getName() ?: '老师';
    }
}
