<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     *
     */
    public function index(SessionInterface $session, BookRepository $repository)
    {
        $cartShopping = $session->get('cartShopping');
        // $session->remove('cartShopping');
        // die();
        // dump($cartShopping);
        if (!$session->has('cartShopping')) $session->set('cartShopping', []);

        $books = $repository->findArray(array_keys($session->get('cartShopping')));


        return $this->render('frontend/cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cartShopping' => $cartShopping,
            'books' => $books
        ]);
    }

    /**
     * @Route("/panier/{id}/ajouter", name="add")
     */
    public function add($id, Request $request, SessionInterface $session)
    {
        $session = new Session();

        if (!$session->has('cartShopping')) $session->set('cartShopping', []);
        $cartShopping = $session->get('cartShopping');
        // $id = $book->getId();
        // $title = $book->getTitle();
        // $quantity = $request->query->get('quantity');
        // dump($id, $quantity);

        if (array_key_exists($id, $cartShopping)) {
            if ($request->query->get('quantity') != null) $cartShopping[$id] = $request->query->get('quantity');
        } else {
            if ($request->query->get('quantity') != null)
                $cartShopping[$id] = $request->query->get('quantity');
            else
                $cartShopping[$id] = 1;
        }

        $session->set('cartShopping', $cartShopping);

        // dump($cartShopping);
        // exit;

        return $this->redirectToRoute('cart', [
            'cartShopping' => $cartShopping
        ]);
        // return $this->render('frontend/cart/add.html.twig', [
        //     'book' => $book
        // ]);
    }

    /**
     * @Route("/panier/{id}/supprimer", name="remove")
     */
    public function remove($id, SessionInterface $session)
    {
        // die('ok');
        $cartShopping = $session->get('cartShopping');

        if (array_key_exists($id, $cartShopping)) {
            unset($cartShopping[$id]);
            $session->set('cartShopping', $cartShopping);
        }
        return $this->redirectToRoute('cart', [
            'cartShopping' => $cartShopping
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
