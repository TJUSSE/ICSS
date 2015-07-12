<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InternArchive
 *
 * @ORM\Table(name="intern_archive")
 * @ORM\Entity
 */
class InternArchive
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="with_apply", type="boolean", nullable=true)
     */
    private $withApply;

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
     * @ORM\ManyToMany(targetEntity="SSE\ICSSBundle\Entity\InternType", mappedBy="availableArchives")
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
     * @return InternArchive
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
     * Set withApply
     *
     * @param boolean $withApply
     * @return InternArchive
     */
    public function setWithApply($withApply)
    {
        $this->withApply = $withApply;

        return $this;
    }

    /**
     * Get withApply
     *
     * @return boolean 
     */
    public function getWithApply()
    {
        return $this->withApply;
    }

    /**
     * Set afterApprove
     *
     * @param boolean $afterApprove
     * @return InternArchive
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
     * @return InternArchive
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
}
