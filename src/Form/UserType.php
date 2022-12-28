<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Avatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '4',
                    'maxlength' => '50',
                ],
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '180',
                    'placeholder' => 'xxx@domain.com'

                ],
                'label' => 'Email'
            ])

            ->add('avatar', EntityType::class, [
                'class' => Avatar::class,
                'label' => 'Choose your avatar',
                'expanded' => true
            ]);

        //If the user is logged, renders the password type else renders the repeated type for register.
        if ($this->security->getUser()) {
            $builder
                ->add('plainPassword', PasswordType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '5',
                        'maxlength' => '255',
                    ],
                    'label' => 'Current password',
                    'placeholder' => 'password'
                ]);
        } else {
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
                        'label' => 'Password'
                       ],
                    'second_options' => [
                        'attr' => [
                            'class' => 'form-control',
                            'minlength' => '5',
                            'maxlength' => '255',
                        ],
                        'label' => 'Confirm Password',
                    ]
                ]);
        }
        
        $builder
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary my-4'
                ],  'label' => 'Submit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
