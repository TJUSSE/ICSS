<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * RecruitApplyArchive
 *
 * @ORM\Table(name="recruit_apply_archive")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class RecruitApplyArchive
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="at", type="datetime", nullable=true)
     */
    private $at;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->at = new \DateTime();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="archive_name", type="string", length=128, nullable=true)
     */
    private $archiveName;

    /**
     * @var string
     *
     * @ORM\Column(name="archive_file", type="string", length=128, nullable=true)
     */
    private $archiveFile;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \SSE\ICSSBundle\Entity\RecruitApply
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\RecruitApply")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="apply_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $apply;

    /**
     * @var \SSE\ICSSBundle\Entity\ArchiveType
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\InternArchive")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="archive_type_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $archiveType;


    /**
     * Set at
     *
     * @param \DateTime $at
     * @return RecruitApplyArchive
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
     * Set archiveName
     *
     * @param string $archiveName
     * @return RecruitApplyArchive
     */
    public function setArchiveName($archiveName)
    {
        $this->archiveName = $archiveName;

        return $this;
    }

    /**
     * Get archiveName
     *
     * @return string
     */
    public function getArchiveName()
    {
        return $this->archiveName;
    }

    /**
     * @return string
     */
    public function getArchiveFile()
    {
        return $this->archiveFile;
    }

    /**
     * @param string $archiveFile
     */
    public function setArchiveFile($archiveFile)
    {
        $this->archiveFile = $archiveFile;
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
     * Set apply
     *
     * @param \SSE\ICSSBundle\Entity\RecruitApply $apply
     * @return RecruitApplyArchive
     */
    public function setApply(\SSE\ICSSBundle\Entity\RecruitApply $apply = null)
    {
        $this->apply = $apply;

        return $this;
    }

    /**
     * Get apply
     *
     * @return \SSE\ICSSBundle\Entity\RecruitApply
     */
    public function getApply()
    {
        return $this->apply;
    }

    /**
     * @return ArchiveType
     */
    public function getArchiveType()
    {
        return $this->archiveType;
    }

    /**
     * @param ArchiveType $archiveType
     */
    public function setArchiveType($archiveType)
    {
        $this->archiveType = $archiveType;
    }


}
