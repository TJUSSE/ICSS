<?php


namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TeacherAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('基本信息')
            ->add('cardId', 'text', ['label' => 'teacher.cardid'])
            ->add('gender', 'sonata_type_model', ['property' => 'name', 'btn_add' => false])
            ->add('name', 'text')
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

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null)
            ->add('cardId', null, ['label' => 'teacher.cardid']);
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('cardId', 'text', ['label' => 'teacher.cardid'])
            ->addIdentifier('name', 'text')
            ->add('gender', 'many_to_one', ['associated_property' => 'name'])
            ->add('officename', 'text')
            ->add('department', 'text', ['label' => 'teacher.department']);
    }
}