<?php

namespace SSE\ICSSBundle\Security\User;

use Doctrine\ORM\EntityManager;
use SSE\ICSSBundle\SSO\SSOService;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class HybridUserProvider implements UserProviderInterface
{
    protected $ssoService;
    protected $entityManager;
    protected $passwordEncoder;

    public function __construct(SSOService $ssoService, EntityManager $entityManager, PasswordEncoder $passwordEncoder)
    {
        $this->ssoService = $ssoService;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param $token
     * @return bool|string
     */
    public function getUsernameForToken($token)
    {
        $attributes = $this->ssoService->getTokenAttribute($token);
        if ($attributes === null) {
            return false;
        }

        $userid = $attributes['UserId'];

        // 查询 Students
        $studentRepo = $this->entityManager->getRepository('SSEICSSBundle:Student');
        $student = $studentRepo->findOneBy(['cardId' => $userid]);
        if ($student) {
            // 是否有缺失字段
            if ($student->getName() === null || trim($student->getName()) === '' ||
                $student->getIdentity() === null || trim($student->getIdentity()) === '' ||
                $student->getGrade() === null || $student->getGrade() < 1000 ||
                $student->getGender() === null || $student->getGender()->getName() === '-' ||
                $student->getDepartment() === null || trim($student->getDepartment()) === '' ||
                $student->getMajor() === null || trim($student->getMajor()) === ''
            ) {
                $info = $this->ssoService->getStudentInfo($token);
                if ($info !== null) {
                    $student->setName($info['name']);
                    $student->setIdentity($info['idcard']);
                    $student->setGrade($info['grade']);
                    $student->setGender(
                        $this->entityManager->getRepository('SSEICSSBundle:Gender')->findOneBy(
                            ['name' => $info['gender']]
                        )
                    );
                    $student->setDepartment($info['department']);
                    $student->setMajor($info['major']);
                    $this->entityManager->flush($student);
                }
            }

            return 's:'.$student->getId();
        }

        // 查询 Teachers
        $teacherRepo = $this->entityManager->getRepository('SSEICSSBundle:Teacher');
        $teacher = $teacherRepo->findOneBy(['cardId' => $userid]);
        if ($teacher) {
            return 't:'.$teacher->getId();
        }

        return false;
    }

    /**
     * 给定用户名和密码，验证是否是内置用户
     *
     * @param $username
     * @param $password
     * @return bool|string
     */
    public function getUsernameForInternalUser($username, $password)
    {
        $userRepo = $this->entityManager->getRepository('SSEICSSBundle:User');
        $user = $userRepo->findOneBy(['username' => $username]);
        if (!$user) {
            return false;
        }
        $hash = $this->passwordEncoder->encode($password, $user->getSalt());
        if ($hash !== $user->getPassword()) {
            return false;
        }

        return 'i:'.$user->getId();
    }

    /**
     * @param string $username
     * @return null|HybridUser
     */
    public function loadUserByUsername($username)
    {
        if (strlen($username) < 2) {
            return null;
        }
        $identifier = substr($username, 0, 2);
        $id = substr($username, 2);

        if ($identifier === 's:') {
            $user = $this->entityManager->getRepository('SSEICSSBundle:Student')->find($id);
        } else {
            if ($identifier === 't:') {
                $user = $this->entityManager->getRepository('SSEICSSBundle:Teacher')->find($id);
            } else {
                if ($identifier === 'i:') {
                    $user = $this->entityManager->getRepository('SSEICSSBundle:User')->find($id);
                } else {
                    throw new UnsupportedUserException();
                }
            }
        }

        if ($user) {
            return new HybridUser($user);
        }

        return null;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof HybridUser) {
            throw new UnsupportedUserException();
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'SSE\ICSSBundle\Security\User\HybridUser';
    }

}