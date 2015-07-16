<?php
/**
 * Created by PhpStorm.
 * User: YiRo
 * Date: 2015/7/15
 * Time: 21:33
 */

namespace SSE\ICSSBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use SSE\ICSSBundle\Security\User\PasswordEncoder;

class UserAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('基本信息')
            ->add('username', 'text', ['label' => 'Name'])
            ->add('password', 'password', ['label' => 'Password'])
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username', null, ['label' => 'Name']);
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username', 'text', ['label' => 'Name']);
    }

    public function prePersist($object)
    {
        $object->setRoles("ROLE_USER");
        $object->setSalt($this->produceSalt());
        $password = (new PasswordEncoder())->encode($object->getPassword(), $object->getSalt());
        $object->setPassword($password);
    }

    public function preUpdate($object)
    {
        $object->setSalt($this->produceSalt());
        $password = (new PasswordEncoder())->encode($object->getPassword(), $object->getSalt());
        $object->setPassword($password);
    }

    protected function produceSalt()
    {
        $salt = (string)rand().(string)date(DATE_RFC822).(string)uniqid();
        $salt = hash('sha256', $salt);

        return $salt;
    }
}