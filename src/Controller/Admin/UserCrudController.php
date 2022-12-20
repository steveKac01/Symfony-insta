<?php

namespace App\Controller\Admin;

use App\Entity\User;

use Easycorp\bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud):crud
    {
         return $crud
         ->setPageTitle('index','InstaPIC - User Administration')
         ->setPaginatorPageSize(20)
         ->setEntityLabelInPlural('Users');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            'pseudo',
            TextField::new('email')->hideOnForm(),
            ArrayField::new('roles'),
            DateTimeField::new('createdAt')->OnlyOnIndex(),
            ImageField::new('avatar')->setUploadDir('/public/images/avatar/')->OnlyOnForms()
        ];
    }
   
}
