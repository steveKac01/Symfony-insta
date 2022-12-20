<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setPageTitle('index', 'InstaPIC - Commentaries Administration')
            ->setPaginatorPageSize(20)
            ->setEntityLabelInSingular('Comment')
            ->setEntityLabelInPlural('Comments');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            'message',
            AssociationField::new('image','Post')->onlyOnIndex(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            AssociationField::new('userComment')->onlyOnIndex(),
        ];
    }
}
