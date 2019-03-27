<?php

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;


class HomeController
{
    /**
     * @var Environment
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        return new Response($this->twig->render('pages/home.html.twig'));
    }
}