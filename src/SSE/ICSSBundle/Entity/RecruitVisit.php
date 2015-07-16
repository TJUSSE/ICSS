<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecruitVisit
 *
 * @ORM\Table(name="recruit_visit")
 * @ORM\Entity
 */
class RecruitVisit
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visit_at", type="datetime", nullable=true)
     */
    private $visitAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \SSE\ICSSBundle\Entity\Recruit
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Recruit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recruit_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $recruit;

    /**
     * @var \SSE\ICSSBundle\Entity\Student
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $student;


    /**
     * Set visitAt
     *
     * @param \DateTime $visitAt
     * @return RecruitVisit
     */
    public function setVisitAt($visitAt)
    {
        $this->visitAt = $visitAt;

        return $this;
    }

    /**
     * Get visitAt
     *
     * @return \DateTime
     */
    public function getVisitAt()
    {
        return $this->visitAt;
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
     * Set recruit
     *
     * @param \SSE\ICSSBundle\Entity\Recruit $recruit
     * @return RecruitVisit
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
     * @return RecruitVisit
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
