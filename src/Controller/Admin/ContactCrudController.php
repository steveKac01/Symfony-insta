<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
         ->setEntityLabelInPlural('Messages')
         ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
          IdField::new('id')->onlyOnIndex(),
          'subject',
          TextField::new('email'),
          TextareaField::new('message')->hideOnIndex()
          ->setFormType(CKEditorType::class),
          DateTimeField::new('createdAt')->OnlyOnIndex(),
        ];
    }

}
