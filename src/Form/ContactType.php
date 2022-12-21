<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'maxlength' => '50',
                    ],
                    'label' => 'Name',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'required' => false
                ]
            )

            ->add(
                'email',
                EmailType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '3',
                        'maxlength' => '50',
                    ],
                    'label' => 'Email (*required)',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ]
            )

            ->add(
                'subject',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'maxlength' => '100',
                    ],
                    'label' => 'Subject',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'required' => false
                ]
            )

            ->add(
                'message',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '10',
                        'maxlength' => '5000',
                        'rows' => 5,
                    ],
                    'label' => 'Your message (*required)',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ]
            )

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary my-4'
                ],  'label' => 'Envoyer votre message'
            ])

            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact',
                'locale' => 'fr',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
