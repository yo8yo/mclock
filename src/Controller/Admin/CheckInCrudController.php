<?php

namespace App\Controller\Admin;

use App\Entity\CheckIn;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\EntityFilterType;

class CheckInCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CheckIn::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('createdAt'),
            TextField::new('duration'),
            AssociationField::new('user'),
            AssociationField::new('site'),
        ];
    }

}
