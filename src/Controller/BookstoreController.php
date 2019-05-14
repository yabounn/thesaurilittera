<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Form\AddedBookType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/book/{id}", name="showBook", requirements={"id"="\d+"})
     */
    public function showBook($id)
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Aucun livre ne correspond à l\'id'.$id);
        }

        $author = $this->getDoctrine()
            ->getRepository(Author::class)
            ->find($id);

        return $this->render('bookstore/showBook.html.twig', [
            'book' => $book,
            'author' => $author
        ]);
    }
}
