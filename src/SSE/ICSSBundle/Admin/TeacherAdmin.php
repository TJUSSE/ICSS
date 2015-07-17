<?php


namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TeacherAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('基本信息')
            ->add('cardId', 'text', ['label' => 'teacher.cardid'])
            ->add('gender', 'sonata_type_model', ['property' => 'name', 'btn_add' => false])
            ->add('name', 'text', ['label' => 'people.name'])
            ->add('officename', 'text', ['required' => false])
            ->add('department', 'text', ['label' => 'teacher.department', 'required' => false])
            ->add('office', 'text', ['required' => false])
            ->add('identity', 'text', ['required' => false])
            ->end()
            ->with('联系方式')
            ->add('email', 'text', ['required' => false])
            ->add('mobile', 'text', ['required' => false])
            ->end();
    }


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'people.name'])
            ->add('cardId', null, ['label' => 'teacher.cardid']);
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('cardId', 'text', ['label' => 'teacher.cardid'])
            ->addIdentifier('name', 'text', ['label' => 'people.name'])
            ->add('gender', 'many_to_one', ['associated_property' => 'name'])
            ->add('officename', 'text')
            ->add('department', 'text', ['label' => 'teacher.department']);
    }

    public function prePersist($object)
    {
        $object->setRoles("ROLE_TEACHER");
    }

}