<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'message',
                CKEditorType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '5',
                        'maxlength' => '250',
                    ],
                    'label' => 'Your message :',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ]
            )

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-secondary my-4'
                ],  'label' => 'Poster'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
