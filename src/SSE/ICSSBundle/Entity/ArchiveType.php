<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchiveType
 *
 * @ORM\Table(name="archive_type")
 * @ORM\Entity
 */
class ArchiveType
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
     * @ORM\Column(name="after_apply", type="boolean", nullable=true)
     */
    private $afterApply;

    /**
     * @var boolean
     *
     * @ORM\Column(name="after_approve", type="boolean", nullable=true)
     */
    private $afterApprove;

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
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\InternType", mappedBy="availableArchiveTypes")
     */
    private $suitableInternTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->suitableInternTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return ArchiveType
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
     * Set afterApply
     *
     * @param boolean $afterApply
     * @return ArchiveType
     */
    public function setAfterApply($afterApply)
    {
        $this->afterApply = $afterApply;

        return $this;
    }

    /**
     * Get afterApply
     *
     * @return boolean
     */
    public function getAfterApply()
    {
        return $this->afterApply;
    }

    /**
     * Set afterApprove
     *
     * @param boolean $afterApprove
     * @return ArchiveType
     */
    public function setAfterApprove($afterApprove)
    {
        $this->afterApprove = $afterApprove;

        return $this;
    }

    /**
     * Get afterApprove
     *
     * @return boolean
     */
    public function getAfterApprove()
    {
        return $this->afterApprove;
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
     * Add suitableInternTypes
     *
     * @param \SSE\ICSSBundle\Entity\InternType $suitableInternTypes
     * @return ArchiveType
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

    public function __toString()
    {
        return $this->getName() ?: '档案类型';
    }
}
