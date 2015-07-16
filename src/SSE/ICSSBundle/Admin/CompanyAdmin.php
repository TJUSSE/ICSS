<?php

namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CompanyAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', ['label' => '企业名称'])
            ->add('location', 'text', ['label' => '企业位置'])
            ->add('hidden', 'checkbox', ['label' => '隐藏该企业', 'required' => false])
            ->add(
                'class',
                'sonata_type_model',
                [
                    'required' => false,
                    'label' => '领域',
                    'multiple' => true,
                    'property' => 'name',
                    'expanded' => false,
                    'btn_add' => false,
                ]
            )
            ->add('intro', 'textarea', ['label' => '企业介绍', 'attr' => array('class' => 'ckeditor')]);
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
            ->addIdentifier('id', 'text')
            ->addIdentifier('name', 'text', ['label' => '企业名称'])
            ->add('location', 'text', ['label' => '企业位置'])
            ->add('class', 'many_to_one', ['label' => '类型', 'associated_property' => 'name']);
    }
}
