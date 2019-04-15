<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookexchangeController extends AbstractController
{
    /**
     * @Route("/bookexchange", name="bookexchange")
     */
    public function index()
    {
        return $this->render('bookexchange/index.html.twig', [
            'controller_name' => 'BookexchangeController',
        ]);
    }
}
