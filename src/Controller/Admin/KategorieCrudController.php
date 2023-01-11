<?php

namespace App\Controller\Admin;

use App\Entity\Kategorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class KategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Kategorie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('reihenfolge'),
            TextField::new('name'),
            BooleanField::new('hide'),
        ];
    }

}
