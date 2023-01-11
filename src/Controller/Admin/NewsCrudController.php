<?php

namespace App\Controller\Admin;

use App\Entity\News;
use Cassandra\Date;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return News::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $news = new News();
        $today = new DateTimeImmutable('now');
        $news->setBild('placeholder.png');
        $news->setCreateAt($today);
        $news->setHide(true);
        $news->setDeleted(false);
        $news->setIsEvent(false);
        $news->setDailyEvent(false);
        return $news;
    }


    public function configureFields(string $pageName): iterable
    {
        if ($pageName == 'new' || $pageName == 'edit'){
            return [
                TextField::new('name'),
                TextField::new('teaser'),
                TextEditorField::new('bodytext'),
                ImageField::new('bild')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->setRequired(false)
                    ->setBasePath('/public/fileadmin/news/')
                    ->setUploadDir('/public/fileadmin/news/'),
                BooleanField::new('isEvent'),
                DateTimeField::new('eventStart'),
                DateTimeField::new('eventEnde'),
                SlugField::new('slug')
                    ->setTargetFieldName('name')
                    ->setLabel('Speaking URL: BaseURL/{slug}'),
                BooleanField::new('hide')
                ->setLabel('Hide'),
            ];
        }
        if ($pageName == 'index'){
            return [
                ImageField::new('bild')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->setRequired(false)
                    ->setBasePath('/fileadmin/news/')
                    ->setUploadDir('/fileadmin/news/'),
                TextField::new('name'),
                TextEditorField::new('teaser'),
                TextEditorField::new('bodytext'),
                BooleanField::new('hide'),
                TextField::new('slug')
                    ->setTemplatePath('admin/field/viewSlug.html.twig')

            ];
        }
    }

}
