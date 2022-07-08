<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('test');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Homepage', 'fas fa-home', 'app_homepage');
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Catégorie', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Produit', 'fa fa-tag', Product::class);
    }
}
