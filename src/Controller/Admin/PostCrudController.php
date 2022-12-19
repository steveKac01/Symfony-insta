<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
           'id',
           'title',
           DateTimeField::new('uploadAt')->OnlyOnIndex(),
           'description',
           AssociationField::new('category'),
           AssociationField::new('userPost')
        ];
    }
   
}
