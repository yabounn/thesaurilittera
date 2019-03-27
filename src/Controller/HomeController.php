<?php

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    // /**
    //  * @var Environment
    //  */
    // public function __construct(Environment $twig)
    // {
    //     $this->twig = $twig;
    // }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        return $this->render('pages/home.html.twig');
        // return new Response($this->twig->render('pages/home.html.twig'));
    }
}