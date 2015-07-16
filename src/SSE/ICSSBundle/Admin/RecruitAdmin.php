<?php


namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RecruitAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', ['label' => '标题'])
            ->add('company', 'sonata_type_model', ['label' => '企业', 'btn_add' => false])
            ->add('ended', 'date', ['label' => '申请结束时间'])
            ->add('applylimit', 'text', ['label' => '申请人数上限（-1 为不限）', 'required' => false])
            ->add(
                'types',
                'sonata_type_model',
                [
                    'required' => true,
                    'label' => '类别',
                    'multiple' => true,
                    'property' => 'name',
                    'expanded' => false,
                    'btn_add' => false,
                ]
            )
            ->add(
                'suitableProjects',
                'sonata_type_model',
                [
                    'required' => true,
                    'label' => '适用学历',
                    'multiple' => true,
                    'property' => 'name',
                    'expanded' => false,
                    'btn_add' => false,
                ]
            )
            ->add(
                'suitableInternTypes',
                'sonata_type_model',
                [
                    'required' => false,
                    'label' => '适用实习性质',
                    'multiple' => true,
                    'property' => 'name',
                    'expanded' => false,
                    'btn_add' => false,
                ]
            )
            ->add('intro', 'textarea', ['label' => '职位介绍', 'attr' => array('class' => 'ckeditor')])
            ->add('hidden', 'checkbox', ['label' => '隐藏', 'required' => false]);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('company.name')
            ->add('hidden');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->addIdentifier('title', 'text', ['label' => '标题'])
            ->add('company.name', 'text', ['label' => '企业'])
            ->add('publishAt', 'date', ['label' => '发布时间', 'format' => 'Y-m-d'])
            ->add('ended', 'date', ['label' => '结束时间', 'format' => 'Y-m-d']);
    }

    // Set default values
    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setApplyLimit(-1);
        $instance->setEnded(new \DateTime());

        return $instance;
    }

    public function prePersist($object)
    {
        $object->setPublishAt(new \DateTime());
    }
}