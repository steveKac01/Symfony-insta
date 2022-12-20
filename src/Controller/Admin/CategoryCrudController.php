<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setPageTitle('index', 'InstaPIC - Category Administration')
            ->setPaginatorPageSize(20)
            ->setEntityLabelInSingular('Message')
            ->setEntityLabelInPlural('Categories');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            'label',
            'description',
            ChoiceField::new('color')->setChoices(['Red' => 'danger', 'Blue' => 'info', 'Green' => 'success', 'Orange' => 'warning'])
        ];
    }
}
