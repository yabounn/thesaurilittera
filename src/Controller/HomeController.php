<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{

    private $repository;

    /**
     * @param BookRepository $repository
     */
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

        $bookInTheRandom = $this->repository->bookInTheRandom();
        // dump($bookInTheRandom);
        // exit();

        return $this->render('frontend/home/home.html.twig', [
            'current_menu' => 'home',
            'books' => $books,
            'bookInTheRandom' => $bookInTheRandom
        ]);
    }
}
