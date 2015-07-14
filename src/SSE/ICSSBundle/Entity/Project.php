<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, unique=true, nullable=true)
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\InternType", mappedBy="suitableProjects")
     */
    private $availableInternTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->availableInternTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Project
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add availableInternTypes
     *
     * @param \SSE\ICSSBundle\Entity\InternType $availableInternTypes
     * @return Project
     */
    public function addAvailableInternType(\SSE\ICSSBundle\Entity\InternType $availableInternTypes)
    {
        $this->availableInternTypes[] = $availableInternTypes;

        return $this;
    }

    /**
     * Remove availableInternTypes
     *
     * @param \SSE\ICSSBundle\Entity\InternType $availableInternTypes
     */
    public function removeAvailableInternType(\SSE\ICSSBundle\Entity\InternType $availableInternTypes)
    {
        $this->availableInternTypes->removeElement($availableInternTypes);
    }

    /**
     * Get availableInternTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvailableInternTypes()
    {
        return $this->availableInternTypes;
    }
}
