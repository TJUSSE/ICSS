<?php
/**
 * This file is part of openvj project.
 *
 * Copyright 2013-2015 openvj dev team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SSE\ICSSBundle\Security\User;

use SSE\ICSSBundle\Entity\BaseUser;
use SSE\ICSSBundle\Entity\Student;
use SSE\ICSSBundle\Entity\Teacher;
use SSE\ICSSBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class HybridUser implements UserInterface, EquatableInterface
{
    /**
     * @var string 用户名，格式为 s:xxx/t:xxx/i:xxx
     */
    private $username;

    /**
     * @var array 用户权限表
     */
    private $roles;

    /**
     * @var int 用户类别，0=学生，1=教师，2=内置用户
     */
    private $type;

    /**
     * @var string 显示用户名
     */
    private $displayName;

    /**
     * @var BaseUser
     */
    private $entity;

    /**
     * @var int 该用户在对应数据表中的 ID
     */
    private $id = 0;

    public function __construct(BaseUser $entity)
    {
        if ($entity instanceof Student) {
            $this->username = 's:' . $entity->getId();
            $this->type = 0;
            $this->displayName = $entity->getName();
        } else if ($entity instanceof Teacher) {
            $this->username = 't:' . $entity->getId();
            $this->type = 1;
            $this->displayName = $entity->getName();
        } else if ($entity instanceof User) {
            $this->username = 'i:' . $entity->getId();
            $this->type = 2;
            $this->displayName = $entity->getUsername();
        } else {
            throw new UnsupportedUserException();
        }

        $this->roles = [$entity->getRole()];
        $this->id = $entity->getId();
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return BaseUser
     */
    public function getEntity()
    {
        return $this->entity;
    }

    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof HybridUser) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        if ($this->type !== $user->getType()) {
            return false;
        }

        if ($this->id !== $user->getId()) {
            return false;
        }

        return true;
    }


}