<?php

namespace App\Controller\Admin;

use App\Entity\{
    Section,
    Teacher,
    User
};

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(TeacherCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Page d\'administration')
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Page d\'accueil', 'fas fa-home', 'app.index');

        yield MenuItem::subMenu('Sections', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Créer une section', 'fas fa-plus', Section::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les sections', 'fas fa-eye', Section::class)
        ]);

        yield MenuItem::subMenu('Enseignants', 'fas fa-folder')->setSubItems([
            MenuItem::linkToCrud('Créer un enseignant', 'fas fa-plus', Teacher::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les enseignants', 'fas fa-eye', Teacher::class)
        ]);

        yield MenuItem::subMenu('Utilisateurs', 'fas fa-users')->setSubItems([
            MenuItem::linkToCrud('Créer un utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les utilisateurs', 'fas fa-eye', User::class)
        ]);
    }
}
