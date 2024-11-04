<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/path")
     */
    #[Route('/')]
    public function index()

    {
        return $this->render("home/index.html.twig");
        // return new Response($content);
    }
}
