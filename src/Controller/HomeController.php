<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BookRepository;


class HomeController extends AbstractController
{
    /**
     * @var BookRepository
     */
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        $books = $this->repository->findAll();

        return $this->render('frontend/home/home.html.twig', [
            'current_menu' => 'home',
            'books' => $books,
        ]);
    }
}
