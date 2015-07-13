<?php
/**
 * This file is part of openvj project.
 *
 * Copyright 2013-2015 openvj dev team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            ->add('intro', 'textarea', ['label' => '企业介绍']);
        /*
            ->add('author', 'entity', array('class' => 'Acme\DemoBundle\Entity\User'))
            ->add('body') //if no type is specified, SonataAdminBundle tries to guess it
        ;*/
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
            ->addIdentifier('name', 'text', ['label' => '企业名称'])
            ->add('hidden', 'boolean', ['editable' => true, 'label' => '隐藏'])
            ->add('location', 'text', ['label' => '企业位置']);
    }
}