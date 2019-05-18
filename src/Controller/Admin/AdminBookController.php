<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookController extends AbstractController
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
     * @Route("/admin", name="admin_book_index")
     */
    public function index()
    {
        $books = $this->repository->findAll();
        return $this->render('admin/book/index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="admin_book_edit")
     */
    public function edit(Book $book)
    {
        return $this->render('admin/book/edit.html.twig', [
            'book' => $book
        ]);
    }
}
