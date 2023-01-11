<?php

namespace App\Controller\Admin;

use App\Entity\Gericht;
use App\Entity\Kategorie;
use App\Entity\News;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
//        return $this->render('bundles/EasyAdminBundle/welcome.html.twig');
        return $this->redirect($adminUrlGenerator->setController(GerichtCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_WALDBAD_USER')){
            yield MenuItem::section('Waldbad');
            yield MenuItem::linkToCrud('News / Events', 'fa fa-newspaper-o', News::class);
        }

        if ($this->isGranted('ROLE_BISTRO_USER')){
            yield MenuItem::section('menükarte');
            yield MenuItem::linkToCrud('Gericht', 'fa fa-cutlery', Gericht::class);
            yield MenuItem::linkToCrud('Kategorien', 'fa fa-tasks', Kategorie::class);
        }

        if ($this->isGranted('ROLE_SUPER_ADMIN')){
            yield MenuItem::section('Benutzer');
            yield MenuItem::linkToCrud('User', 'fa fa-user-circle', User::class);
        }
        yield MenuItem::section('Zurück');
        yield MenuItem::linkToUrl('Zum Menü', 'fa fa-chevron-left' , $this->generateUrl('menu'));
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
