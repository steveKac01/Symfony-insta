<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }
    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setPageTitle('index', 'InstaPIC - Posts Administration')
            ->setPaginatorPageSize(20)
            ->setEntityLabelInPlural('Posts')
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('url')->setUploadDir('/public/images/posts/')->OnlyOnForms(),
            'title',

            TextareaField::new('description','Content')->hideOnIndex()
            ->setFormType(CKEditorType::class),
            AssociationField::new('category'),
            AssociationField::new('userPost','User')->hideOnForm(),
            DateTimeField::new('uploadAt','CreatedAt')->OnlyOnIndex()
        ];
    }
}
