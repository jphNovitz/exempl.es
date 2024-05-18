<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', []);
    }

    #[Route('/sitemap', name: 'app_sitemap')]
    public function sitemap(): Response
    {
        $response = new Response($this->render('default/sitemap.xml.twig'));
        $response->headers->set('Content-Type', 'application/xml');
        return  $response;
    }


}
