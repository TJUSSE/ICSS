<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recruit
 *
 * @ORM\Table(name="recruit")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Recruit
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_at", type="datetime", nullable=true)
     */
    private $publishAt;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->publishAt = new \DateTime();
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended", type="datetime", nullable=true)
     */
    private $ended;

    /**
     * @var string
     *
     * @ORM\Column(name="intro", type="text", nullable=true)
     */
    private $intro;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden", type="boolean", nullable=true)
     */
    private $hidden;

    /**
     * @var integer
     *
     * @ORM\Column(name="apply_limit", type="integer", nullable=true)
     */
    private $applyLimit;

    /**
     * @var integer
     *
     * @ORM\Column(name="visit_count", type="integer", nullable=true)
     */
    private $visitCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \SSE\ICSSBundle\Entity\Company
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Company")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $company;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\RecruitType")
     * @ORM\JoinTable(name="recruits_types",
     *   joinColumns={
     *     @ORM\JoinColumn(name="recruit_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="recruit_type_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $types;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\InternType")
     * @ORM\JoinTable(name="recruits_intern_types",
     *   joinColumns={
     *     @ORM\JoinColumn(name="recruit_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="intern_type_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $suitableInternTypes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\Project")
     * @ORM\JoinTable(name="recruits_projects",
     *   joinColumns={
     *     @ORM\JoinColumn(name="recruit_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $suitableProjects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
        $this->suitableInternTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->suitableProjects = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set publishAt
     *
     * @param \DateTime $publishAt
     * @return Recruit
     */
    public function setPublishAt($publishAt)
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    /**
     * Get publishAt
     *
     * @return \DateTime
     */
    public function getPublishAt()
    {
        return $this->publishAt;
    }

    /**
     * Set ended
     *
     * @param \DateTime $ended
     * @return Recruit
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return \DateTime
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * Set intro
     *
     * @param string $intro
     * @return Recruit
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
     * Set hidden
     *
     * @param boolean $hidden
     * @return Recruit
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
     * Set applyLimit
     *
     * @param integer $applyLimit
     * @return Recruit
     */
    public function setApplyLimit($applyLimit)
    {
        $this->applyLimit = $applyLimit;

        return $this;
    }

    /**
     * Get applyLimit
     *
     * @return integer
     */
    public function getApplyLimit()
    {
        return $this->applyLimit;
    }

    /**
     * Set visitCount
     *
     * @param integer $visitCount
     * @return Recruit
     */
    public function setVisitCount($visitCount)
    {
        $this->visitCount = $visitCount;

        return $this;
    }

    /**
     * Get visitCount
     *
     * @return integer
     */
    public function getVisitCount()
    {
        return $this->visitCount;
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
     * Set company
     *
     * @param \SSE\ICSSBundle\Entity\Company $company
     * @return Recruit
     */
    public function setCompany(\SSE\ICSSBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \SSE\ICSSBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add types
     *
     * @param \SSE\ICSSBundle\Entity\RecruitType $types
     * @return Recruit
     */
    public function addType(\SSE\ICSSBundle\Entity\RecruitType $types)
    {
        $this->types[] = $types;

        return $this;
    }

    /**
     * Remove types
     *
     * @param \SSE\ICSSBundle\Entity\RecruitType $types
     */
    public function removeType(\SSE\ICSSBundle\Entity\RecruitType $types)
    {
        $this->types->removeElement($types);
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Add suitableInternTypes
     *
     * @param \SSE\ICSSBundle\Entity\InternType $suitableInternTypes
     * @return Recruit
     */
    public function addSuitableInternType(\SSE\ICSSBundle\Entity\InternType $suitableInternTypes)
    {
        $this->suitableInternTypes[] = $suitableInternTypes;

        return $this;
    }

    /**
     * Remove suitableInternTypes
     *
     * @param \SSE\ICSSBundle\Entity\InternType $suitableInternTypes
     */
    public function removeSuitableInternType(\SSE\ICSSBundle\Entity\InternType $suitableInternTypes)
    {
        $this->suitableInternTypes->removeElement($suitableInternTypes);
    }

    /**
     * Get suitableInternTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuitableInternTypes()
    {
        return $this->suitableInternTypes;
    }

    /**
     * Add suitableProjects
     *
     * @param \SSE\ICSSBundle\Entity\Project $suitableProjects
     * @return Recruit
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

    /**
     * @var string
     */
    private $title;


    /**
     * Set title
     *
     * @param string $title
     * @return Recruit
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function __toString()
    {
        return $this->getTitle() ?: '招聘信息';
    }
}
