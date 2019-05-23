<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{

    /**
     * @Route("/panier", name="cart")
     *
     */
    public function index()
    {
        return $this->render('frontend/cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    /**
     * @Route("/panier/{id}/ajouter", name="add")
     */
    public function add($id, Book $book, BookRepository $book_repo, SessionInterface $session)
    {
        $book = $book_repo->find($id);


        return $this->render('frontend/cart/add.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/panier/livraison", name="delivery")
     */
    public function delivery()
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        // $form->handleRequest($request);

        return $this->render('frontend/cart/delivery.html.twig', [
            'formAddress' => $form->createView()
        ]);
    }

    /**
     * @Route("/panier/valider", name="validate")
     */
    public function validate()
    {
        return $this->render('frontend/cart/validate.html.twig');
    }
}
