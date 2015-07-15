<?php

namespace SSE\ICSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direction
 *
 * @ORM\Table(name="direction")
 * @ORM\Entity
 */
class Direction
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
     * Set name
     *
     * @param string $name
     * @return Direction
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

    public function __toString()
    {
        return $this->getName() ?: '方向';
    }
}
