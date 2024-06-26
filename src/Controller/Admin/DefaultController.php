<?php

namespace App\Controller\Admin;

use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/admin/', name: 'admin_default')]
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('admin/default/index.html.twig', [
            'totalSites' => $siteRepository->count([]),
        ]);
    }
}
