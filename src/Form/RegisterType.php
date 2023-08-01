<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'label' => $this->translator->trans('username'),
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'label' => $this->translator->trans('email'),
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'label' => $this->translator->trans('password'),
            ])
            ->add('register', SubmitType::class, [
                'label' => $this->translator->trans('register'),
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
