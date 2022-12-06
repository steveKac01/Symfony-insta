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
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords do not match.',
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '5',
                        'maxlength' => '255',
                    ],
                    'label' => 'Password',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '5',
                        'maxlength' => '255',
                    ],
                    'label' => 'Confirm Password',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'constraints' => [
                    new Assert\Length(['min' => 5, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('newPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '255',
                ],
                'label' => 'New password',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 5, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])


            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary my-4'
                ],  'label' => 'Submit'
            ]);
    }
}
