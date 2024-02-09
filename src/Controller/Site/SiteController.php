<?php

namespace App\Controller\Site;

use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{

    public function __construct(private SiteRepository $siteRepository)
    {

    }

    #[Route('/', name: 'app_site_index')]
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }
}
