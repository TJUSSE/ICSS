<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * RecruitApplyArchive
 *
 * @ORM\Table(name="recruit_apply_archive")
 * @ORM\Entity
 * @Vich\Uploadable
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
     * @var string
     *
     * @ORM\Column(name="archiveName", type="string", length=128, nullable=true)
     */

    private $archiveName;

    /**
     *
     * @Vich\UploadableField(mapping="apply_archive", fileNameProperty="archiveName")
     *
     * @var File $archiveFile
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
     *   @ORM\JoinColumn(name="apply_id", referencedColumnName="id")
     * })
     */
    private $apply;

    /**
     * @var \SSE\ICSSBundle\Entity\InternArchive
     *
     * @ORM\ManyToOne(targetEntity="SSE\ICSSBundle\Entity\InternArchive")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="archive_id", referencedColumnName="id")
     * })
     */
    private $archive;


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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $archiveFile
     */
    public function setArchiveFile(File $archiveFile = null)
    {
        $this->archiveFile=$archiveFile;
        if($archiveFile)
        {
            $this->at=new \DateTime('now');
        }
    }
    /**
     * @return File
     */
    public function getArchiveFile()
    {
        return $this->archiveFile;
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
     * Set archive
     *
     * @param \SSE\ICSSBundle\Entity\InternArchive $archive
     * @return RecruitApplyArchive
     */
    public function setArchive(\SSE\ICSSBundle\Entity\InternArchive $archive = null)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Get archive
     *
     * @return \SSE\ICSSBundle\Entity\InternArchive
     */
    public function getArchive()
    {
        return $this->archive;
    }
}
