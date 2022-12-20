<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }
    
    public function configureCrud(Crud $crud):crud
    {
         return $crud
         ->setPageTitle('index','InstaPIC - Contact messages Administration')
         ->setPaginatorPageSize(20)
         ->setEntityLabelInSingular('Message')
         ->setEntityLabelInPlural('Messages');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
          IdField::new('id')->hideOnForm(),
          'subject',
          'email',
          'message',
          DateTimeField::new('createdAt')->OnlyOnIndex(),
        ];
    }

}
