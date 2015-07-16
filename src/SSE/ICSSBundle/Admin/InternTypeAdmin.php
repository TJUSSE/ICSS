<?php

namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class InternTypeAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', ['label' => '实习性质名称'])
            ->add('approve', 'checkbox', ['label' => '自动审批通过', 'required' => false])
            ->add(
                'suitableProjects',
                'sonata_type_model',
                [
                    'required' => false,
                    'label' => '所适用专业',
                    'multiple' => true,
                    'property' => 'name',
                    'expanded' => true,
                ]
            )
            ->add(
                'availableArchiveTypes',
                'sonata_type_model',
                [
                    'required' => false,
                    'label' => '可递交的档案类型',
                    'multiple' => true,
                    'property' => 'name',
                    'expanded' => true,
                ]
            );
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'text', ['label' => '实习性质'])
            ->add('suitableProjects', 'many_to_one', ['label' => '适用学历', 'associated_property' => 'name'])
            ->add('availableArchiveTypes', 'many_to_one', ['label' => '可递交档案', 'associated_property' => 'name']);
    }
}