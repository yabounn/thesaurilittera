<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookstoreController extends AbstractController
{
    /**
     * @Route("/bookstore", name="bookstore")
     */
    public function index()
    {
        return $this->render('bookstore/index.html.twig', [
            'current_menu' => 'bookstore',
        ]);
    }
}
