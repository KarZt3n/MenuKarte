<?php

namespace App\Controller\Admin;

use App\Entity\Gericht;
use App\Form\GerichtType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class GerichtCrudController extends AbstractCrudController
{
    public function __construct() {
//        var_dump(ImageField::OPTION_UPLOAD_DIR);
    }

    public static function getEntityFqcn(): string
    {
        return Gericht::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
//            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action){
                return $action->setIcon('fa fa-cutlery')->addCssClass('btn btn-success');
            });
    }


    public function configureFields(string $pageName): iterable
    {
        if ($pageName == 'new'){
            return [
                IntegerField::new('reihenfolge'),
                TextField::new('name'),
                TextEditorField::new('beschreibung'),
                ImageField::new('bild')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->setRequired(true)
                    ->setBasePath('/public/fileadmin/bilder/')
                    ->setUploadDir('/public/fileadmin/bilder/'),
                AssociationField::new('kategorie')
                    ->setRequired(true),
                NumberField::new('preis'),

            ];
        }
        if ($pageName == 'edit'){
            return [
                IntegerField::new('reihenfolge'),
                TextField::new('name'),
                TextEditorField::new('beschreibung'),
                ImageField::new('bild')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->setRequired(false)
                    ->setBasePath('/public/fileadmin/bilder/')
                    ->setUploadDir('/public/fileadmin/bilder/'),
                AssociationField::new('kategorie')
                    ->setRequired(true),
                NumberField::new('preis'),

            ];
        }
        if ($pageName == 'index'){
            return [
                IntegerField::new('reihenfolge'),
                TextField::new('name'),
                TextEditorField::new('beschreibung'),
                ImageField::new('bild')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->setRequired(false)
                    ->setBasePath('/fileadmin/bilder/')
                    ->setUploadDir('/fileadmin/bilder/'),
                AssociationField::new('kategorie')
                    ->setRequired(true),
                NumberField::new('preis'),

            ];
        }
    }

}
