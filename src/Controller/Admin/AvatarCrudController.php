<?php

namespace App\Controller\Admin;

use App\Entity\Avatar;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AvatarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Avatar::class;
    }
    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setPageTitle('index', 'InstaPIC - Avatars Administration')
            ->setPaginatorPageSize(20)
            ->setEntityLabelInPlural('Avatars');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label'),
            ImageField::new('url','Image')->setUploadDir('/public/images/avatar/')->setBasePath('/images/avatar/'),
        ];
    }
    
}
