<?php


namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RecruitApplyAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('description', 'text', ['required' => false])
            ->add('approved', 'checkbox', ['required' => false]);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('student.name')
            ->add('recruit.title')
            ->add('internType.name');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('student.name', 'text')
            ->addIdentifier('recruit.title', 'text')
            ->addIdentifier('internType.name', 'text')
            ->add(
                'archive',
                'string',
                ['template' => 'SSEICSSBundle:Admin:list_uploaded_archives.html.twig', 'label' => '档案状态']
            )
            ->add('approved', 'boolean');
    }
}