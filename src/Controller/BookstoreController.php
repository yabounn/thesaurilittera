<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddedBookType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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
     * @Route("/livre", name="addedBook")
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
}
