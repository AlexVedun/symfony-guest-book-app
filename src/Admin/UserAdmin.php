<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('email', EmailType::class);
        $form->add('userName', TextType::class);
        $form->add('roles', ChoiceType::class, [
            'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
            ],
            'multiple' => true,
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('userName');
        $filter->add('email');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('email');
        $list->add('userName');
        $list->add('roles');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id');
        $show->add('email');
        $show->add('userName');
        $show->add('roles');
    }
}
