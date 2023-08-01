<?php

namespace App\Admin;

use App\Entity\User;
use Carbon\Carbon;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class WishAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('createdAt', DateTimeType::class, [
            'data' => Carbon::now(),
        ]);
        $form->add('userName', TextType::class);
        $form->add('email', EmailType::class);
        $form->add('homePage', UrlType::class, [
            'required' => false,
        ]);
        $form->add('content', CKEditorType::class);
        $form->add('isModerated', CheckboxType::class, [
            'required' => false,
        ]);
        $form->add('user', ModelType::class, [
            'class' => User::class,
            'property' => 'email',
            'required' => false,
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('userName');
        $filter->add('email');
        $filter->add('isModerated');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('createdAt');
        $list->add('isModerated');
        $list->add('userName');
        $list->add('email');
        $list->add('content');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id');
        $show->add('createdAt');
        $show->add('userName');
        $show->add('email');
        $show->add('homePage');
        $show->add('content');
        $show->add('isModerated');
        $show->add('imageFile');
    }
}
