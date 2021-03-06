<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity
 */
class Company
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=256, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="intro", type="text", nullable=true)
     */
    private $intro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="text", nullable=true)
     */
    private $location;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden", type="boolean", nullable=true)
     */
    private $hidden;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\CompanyClass")
     * @ORM\JoinTable(name="company_with_class",
     *   joinColumns={
     *     @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="class_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $class;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Add class
     *
     * @param \SSE\ICSSBundle\Entity\CompanyClass $class
     * @return Company
     */
    public function addClass(\SSE\ICSSBundle\Entity\CompanyClass $class)
    {
        $this->class[] = $class;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set intro
     *
     * @param string $intro
     * @return Company
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Company
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Company
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     * @return Company
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
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

    public function __toString()
    {
        return $this->getName() ?: '企业';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->class = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Remove class
     *
     * @param \SSE\ICSSBundle\Entity\CompanyClass $class
     */
    public function removeClass(\SSE\ICSSBundle\Entity\CompanyClass $class)
    {
        $this->class->removeElement($class);
    }
}
