<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', PasswordType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '5',
                'maxlength' => '255',
            ],
            'label' => 'Current password',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])

            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords do not match.',
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '8',
                        'maxlength' => '255',
                    ],
                    'label' => 'New Password : Must be 8 characters long with at least 1 capital letter and 1 special character.',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ], 'constraints' => [
                        new Assert\Regex('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/','Password not valid.')
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '8',
                        'maxlength' => '255',
                    ],
                    'label' => 'Confirm Password',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ]
              
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary my-4'
                ],  'label' => 'Submit'
            ]);
    }
}
