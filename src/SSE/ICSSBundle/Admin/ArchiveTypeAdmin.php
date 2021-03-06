<?php


namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArchiveTypeAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('afterapply', 'checkbox', ['label' => '该档案需要在申请后递交', 'required' => false])
            ->add('afterapprove', 'checkbox', ['label' => '该档案需要在审批后递交', 'required' => false]);
    }


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'text')
            ->add('afterapply', 'boolean', ['editable' => true, 'label' => '申请后递交'])
            ->add('afterapprove', 'boolean', ['editable' => true, 'label' => '审批后递交']);
    }
}