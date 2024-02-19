<?php

namespace App\Controller\Site;

use App\Entity\Site;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{

    #[Route('/', name: 'app_site_index')]
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }

    #[Route('/site/{slug}', name: 'app_site_show')]
    public function show(Site $site): Response
    {
        return $this->render('site/show.html.twig', [
            'site' => $site
        ]);
    }
}
