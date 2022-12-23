<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '50',

                ],
                'label' => 'Title',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])

            ->add('description', CKEditorType::class, [
                'config_name' => 'main_config',
                
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '255',
                    'rows' => 5

                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])

            ->add('postThumbnail', VichImageType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Thumbnail',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'delete_label' => 'Change thumbnail ',
                'download_uri' => false,
                'allow_delete' => false,
                // If we are editing or creating a new post the required option changes.
                'required' => $options['data']->getUrl()?false:true,
                'constraints' => [
                    new Assert\File(maxSize: 1048576, maxSizeMessage: "The thumbnail must weight lesser than 1 mo.")
                ]
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'attr' => [
                    'class' => 'list-group mt-4'
                ],
                'row_attr' => [
                    'class' => 'mt-4'
                ],
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary my-4'
                ],  'label' => 'Submit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
