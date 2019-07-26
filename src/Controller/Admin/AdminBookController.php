<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\AddedBookType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @Route("/admin/book", name="admin_book_index")
     */
    public function index()
    {

        return $this->render('admin/book/index.html.twig', []);
    }

    /**
     * @Route("/admin/book/all", name="admin_book_all")
     */
    public function all()
    {
        $books = $this->repository->findAll();
        return $this->render('admin/book/all.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/admin/book/edit/{id}", name="admin_book_edit")
     */
    public function edit(Book $book)
    {
        return $this->render('admin/book/edit.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/admin/book/add", name="admin_book_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $book = new book();

        $form = $this->createForm(AddedBookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($book);
            $manager->flush();
        }
        return $this->render('admin/book/add.html.twig', [
            'formAddedBook' => $form->createView()
        ]);
    }
}
