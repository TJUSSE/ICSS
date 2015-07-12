<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecruitApply
 *
 * @ORM\Table(name="recruit_apply")
 * @ORM\Entity
 */
class RecruitApply
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="at", type="datetime", nullable=true)
     */
    private $at;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved", type="boolean", nullable=true)
     */
    private $approved;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canceled", type="boolean", nullable=true)
     */
    private $canceled;

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
     * @ORM\OneToMany(targetEntity="SSE\ICSSBundle\Entity\RecruitApplyArchive", mappedBy="apply")
     */
    private $archives;

    /**
     * @var \SSE\ICSSBundle\Entity\Recruit
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Recruit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recruit_id", referencedColumnName="id")
     * })
     */
    private $recruit;

    /**
     * @var \SSE\ICSSBundle\Entity\Student
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     */
    private $student;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->archives = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set at
     *
     * @param \DateTime $at
     * @return RecruitApply
     */
    public function setAt($at)
    {
        $this->at = $at;

        return $this;
    }

    /**
     * Get at
     *
     * @return \DateTime 
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return RecruitApply
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     * @return RecruitApply
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set canceled
     *
     * @param boolean $canceled
     * @return RecruitApply
     */
    public function setCanceled($canceled)
    {
        $this->canceled = $canceled;

        return $this;
    }

    /**
     * Get canceled
     *
     * @return boolean 
     */
    public function getCanceled()
    {
        return $this->canceled;
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
     * Add archives
     *
     * @param \SSE\ICSSBundle\Entity\RecruitApplyArchive $archives
     * @return RecruitApply
     */
    public function addArchive(\SSE\ICSSBundle\Entity\RecruitApplyArchive $archives)
    {
        $this->archives[] = $archives;

        return $this;
    }

    /**
     * Remove archives
     *
     * @param \SSE\ICSSBundle\Entity\RecruitApplyArchive $archives
     */
    public function removeArchive(\SSE\ICSSBundle\Entity\RecruitApplyArchive $archives)
    {
        $this->archives->removeElement($archives);
    }

    /**
     * Get archives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArchives()
    {
        return $this->archives;
    }

    /**
     * Set recruit
     *
     * @param \SSE\ICSSBundle\Entity\Recruit $recruit
     * @return RecruitApply
     */
    public function setRecruit(\SSE\ICSSBundle\Entity\Recruit $recruit = null)
    {
        $this->recruit = $recruit;

        return $this;
    }

    /**
     * Get recruit
     *
     * @return \SSE\ICSSBundle\Entity\Recruit 
     */
    public function getRecruit()
    {
        return $this->recruit;
    }

    /**
     * Set student
     *
     * @param \SSE\ICSSBundle\Entity\Student $student
     * @return RecruitApply
     */
    public function setStudent(\SSE\ICSSBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \SSE\ICSSBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }
}
