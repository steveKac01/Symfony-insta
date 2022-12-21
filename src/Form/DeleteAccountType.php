<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '5',
                'maxlength' => '250',

            ],
            'label' => 'Email',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])

        ->add('plainPassword', PasswordType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '5',
                'maxlength' => '255',
            ],
            'label' => 'Password',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])

        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary my-4'
            ],  'label' => 'Submit'
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
