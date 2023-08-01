<?php

namespace App\Form;

use App\Entity\Wish;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class WishType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userName', TextType::class, [
                'label' => $this->translator->trans('username'),
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
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
            ->add('homePage', UrlType::class, [
                'label' => $this->translator->trans('homepage'),
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'required' => false,
            ])
            ->add('content', CKEditorType::class, [
                'label' => $this->translator->trans('message'),
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'config' => [
                    'allowedContent' => 'a[!href]; code; i; strike; strong',
                ],
            ])
            ->add('imageFile', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'label' => $this->translator->trans('wish.image.add'),
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                    ]),
                ],
            ])
            ->add('capcha', CaptchaType::class, [
                'attr' => [
                    'class' => 'form-control mt-2'
                ],
                'row_attr' => [
                    'class' => 'mb-3',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('submit'),
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
