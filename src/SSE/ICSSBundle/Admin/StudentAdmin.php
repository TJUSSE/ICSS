<?php

namespace SSE\ICSSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use SSE\ICSSBundle\Builder\DirectionListBuilder;
use SSE\ICSSBundle\Builder\GenderListBuilder;
use SSE\ICSSBundle\Builder\GradeListBuilder;
use SSE\ICSSBundle\Builder\ProjectListBuilder;

class StudentAdmin extends Admin
{
    /** @var ProjectListBuilder */
    protected $projectListBuilder;

    /** @var  GradeListBuilder */
    protected $gradeListBuilder;

    /** @var  DirectionListBuilder */
    protected $directionListBuilder;

    /** @var  GenderListBuilder */
    protected $genderListBuilder;

    public function setProjectListBuilder(ProjectListBuilder $builder)
    {
        $this->projectListBuilder = $builder;
    }

    public function setGradeListBuilder(GradeListBuilder $builder)
    {
        $this->gradeListBuilder = $builder;
    }

    public function setDirectionListBuilder(DirectionListBuilder $builder)
    {
        $this->directionListBuilder = $builder;
    }

    public function setGenderListBuilder(GenderListBuilder $builder)
    {
        $this->genderListBuilder = $builder;
    }


    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('基本信息', array('description' => '您可以只填写学生学号、学历和专业方向，学生个人信息将在学生首次登录系统时，自动从学工网上获取。'))
            ->add('cardId', 'text', ['label' => 'student.cardid'])
            ->add('project', 'sonata_type_model', ['property' => 'name', 'btn_add' => false, 'required' => false])
            ->add('direction', 'sonata_type_model', ['property' => 'name', 'btn_add' => false, 'required' => false])
            ->add('gender', 'sonata_type_model', ['property' => 'name', 'btn_add' => false, 'required' => false])
            ->add('name', 'text', ['required' => false, 'label' => 'people.name'])
            ->add('grade', 'text', ['required' => false])
            ->add('department', 'text', ['required' => false])
            ->add('major', 'text', ['required' => false])
            ->add('mentor', 'sonata_type_model', ['property' => 'name', 'btn_add' => false, 'required' => false])
            ->add('identity', 'text', ['required' => false])
            ->end()
            ->with('联系方式')
            ->add('email', 'text', ['required' => false])
            ->add('mobile', 'text', ['required' => false])
            ->end()
            ->with('其他')
            ->add('valid', 'checkbox', ['label' => '账号有效', 'required' => false])
            ->end();
    }

    // Set default values
    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setEnabled(true);
        $instance->setValid(true);
        //$instance->setDirection(1);
        //$instance->setProject(1);
        $instance->setDepartment('软件学院');
        $instance->setMajor('软件工程');

        return $instance;
    }


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'people.name'])
            ->add('cardId', null, ['label' => 'student.cardid'])
            ->add(
                'project.id',
                'doctrine_orm_choice',
                [],
                'choice',
                [
                    'choices' => $this->projectListBuilder->getList(),
                    'expanded' => true,
                    'multiple' => true,
                ]
            )
            ->add(
                'grade',
                'doctrine_orm_choice',
                [],
                'choice',
                [
                    'choices' => $this->gradeListBuilder->getList(),
                    'expanded' => false,
                    'multiple' => false,
                ]
            )
            ->add(
                'gender.id',
                'doctrine_orm_choice',
                [],
                'choice',
                [
                    'choices' => $this->genderListBuilder->getList(),
                    'expanded' => true,
                    'multiple' => true,
                ]
            )
            ->add(
                'direction.id',
                'doctrine_orm_choice',
                [],
                'choice',
                [
                    'choices' => $this->directionListBuilder->getList(),
                    'expanded' => false,
                    'multiple' => false,
                ]
            );
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('cardId', 'text', ['label' => 'student.cardid'])
            ->addIdentifier('name', 'text', ['label' => 'people.name'])
            ->add('gender', 'many_to_one', ['associated_property' => 'name'])
            ->add('grade', 'text')
            ->add('direction', 'many_to_one', ['associated_property' => 'name']);
    }

    public function prePersist($object)
    {
        $object->setRoles("ROLE_STUDENT");
    }
}