<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddedBookType;
use App\Form\FilterByCategoryType;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/librairie", name="bookstore")
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(FilterByCategoryType::class);
        $form->handleRequest($request);

        $category = $request->query->get('category');
        $criteria = [];
        if ($category) {
            $criteria = ['category' => $category];
        }

        $books = $paginator->paginate(
            $this->repository->findBy($criteria),
            $request->query->getInt('page', 1),
            4
        );


        return $this->render('frontend/bookstore/index.html.twig', [
            'current_menu' => 'bookstore',
            'books' => $books,
            'form' => $form->createView()
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

        return $this->render('frontend/bookstore/addedBook.html.twig', [
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

        return $this->render('frontend/bookstore/showBook.html.twig', [
            'book' => $book,
        ]);
    }
}
