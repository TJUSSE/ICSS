<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InternType
 *
 * @ORM\Table(name="intern_type")
 * @ORM\Entity
 */
class InternType
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, unique=true, nullable=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approve", type="boolean", nullable=true)
     */
    private $approve;

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
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\ArchiveType", inversedBy="availableInternTypes")
     * @ORM\JoinTable(name="intern_types_archives",
     *   joinColumns={
     *     @ORM\JoinColumn(name="intern_type_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="archive_type", referencedColumnName="id")
     *   }
     * )
     */
    private $availableArchiveTypes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\Project")
     * @ORM\JoinTable(name="intern_types_projects",
     *   joinColumns={
     *     @ORM\JoinColumn(name="intern_type_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     *   }
     * )
     */
    private $suitableProjects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->availableArchiveTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->suitableProjects = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return InternType
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
     * Set approve
     *
     * @param boolean $approve
     * @return InternType
     */
    public function setApprove($approve)
    {
        $this->approve = $approve;

        return $this;
    }

    /**
     * Get approve
     *
     * @return boolean
     */
    public function getApprove()
    {
        return $this->approve;
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
     * Add availableArchiveTypes
     *
     * @param \SSE\ICSSBundle\Entity\ArchiveType $availableArchives
     * @return InternType
     */
    public function addAvailableArchiveType(\SSE\ICSSBundle\Entity\ArchiveType $availableArchives)
    {
        $this->availableArchiveTypes[] = $availableArchives;

        return $this;
    }

    /**
     * Remove availableArchiveTypes
     *
     * @param \SSE\ICSSBundle\Entity\ArchiveType $availableArchives
     */
    public function removeAvailableArchiveType(\SSE\ICSSBundle\Entity\ArchiveType $availableArchives)
    {
        $this->availableArchiveTypes->removeElement($availableArchives);
    }

    /**
     * Get availableArchiveTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvailableArchiveTypes()
    {
        return $this->availableArchiveTypes;
    }

    /**
     * Add suitableProjects
     *
     * @param \SSE\ICSSBundle\Entity\Project $suitableProjects
     * @return InternType
     */
    public function addSuitableProject(\SSE\ICSSBundle\Entity\Project $suitableProjects)
    {
        $this->suitableProjects[] = $suitableProjects;

        return $this;
    }

    /**
     * Remove suitableProjects
     *
     * @param \SSE\ICSSBundle\Entity\Project $suitableProjects
     */
    public function removeSuitableProject(\SSE\ICSSBundle\Entity\Project $suitableProjects)
    {
        $this->suitableProjects->removeElement($suitableProjects);
    }

    /**
     * Get suitableProjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuitableProjects()
    {
        return $this->suitableProjects;
    }

    public function __toString()
    {
        return $this->getName() ?: '实习性质';
    }
}
