<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddedBookType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BookRepository;

class BookstoreController extends AbstractController
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
     * @Route("/bookstore", name="bookstore")
     * @return Response
     */
    public function index(): Response
    {
        // $repository = $this->getDoctrine()->getRepository(Book::class);
        // dump($repository);
        $books = $this->repository->findAll();
        // dump($books);

        return $this->render('bookstore/index.html.twig', [
            'current_menu' => 'bookstore',
            'books' => $books
        ]);
    }

    /**
     * @Route("/book/add", name="addedBook")
     */

    public function addedBook(Request $request, ObjectManager $manager)
    {
        $book = new book();

        $form = $this->createForm(AddedBookType::class, $book);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($book);
            $manager->flush();
        }

        return $this->render('bookstore/addedBook.html.twig', [
            'formAddedBook' => $form->createView()
        ]);
    }

    /**
     * @Route("/book/{id}-{slug}", name="showBook", requirements={"id": "\d+", "slug": "[a-z0-9\-]*"})
     * @param Book $book
     * @return response
     */
    public function showBook(Book $book, string $slug): Response // Injection de dependance en param, SF sait quel id envoyer
    {
        // Vérifie si slug ok en "3ème param on passe une 301 
        if ($book->getSlug() !== $slug) {
            return $this->redirectToRoute('showBook', [
                'id' => $book->getId(),
                'slug' => $book->getSlug()
            ], 301);
        }

        return $this->render('bookstore/showBook.html.twig', [
            'book' => $book,
        ]);
    }
}
