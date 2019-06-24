<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\BookRepository;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     */
    public function index(SessionInterface $session, BookRepository $repository)
    {
        $cartShopping = $session->get('cartShopping');

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

        if (array_key_exists($id, $cartShopping)) {
            if ($request->query->get('quantity') != null) $cartShopping[$id] = $request->query->get('quantity');
            $this->addFlash('success', 'La quantité a été modifié !');
        } else {
            if ($request->query->get('quantity') != null)
                $cartShopping[$id] = $request->query->get('quantity');
            else
                $cartShopping[$id] = 1;

            $this->addFlash('success', 'Le livre a été ajouté !');
        }

        $session->set('cartShopping', $cartShopping);

        return $this->redirectToRoute('cart', [
            'cartShopping' => $cartShopping
        ]);
    }

    /**
     * @Route("/panier/{id}/supprimer", name="remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $cartShopping = $session->get('cartShopping');

        if (array_key_exists($id, $cartShopping)) {
            unset($cartShopping[$id]);
            $session->set('cartShopping', $cartShopping);
        }

        $this->addFlash('success', 'Le livre a bien été supprimé !');

        return $this->redirectToRoute('cart', [
            'cartShopping' => $cartShopping
        ]);
    }

    /**
     * @Route("/panier/livraison", name="delivery")
     */
    public function delvery(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $address->setCreatedAt(new \DateTime());
            $address->setUser($user);
            $manager->persist($address);
            $manager->flush();

            return $this->redirectToRoute('delivery');
        }

        return $this->render('frontend/cart/delivery.html.twig', [
            'formAddress' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/livraison/adresse/supprimer/{id}", name="removeAddressDelivery")
     */
    public function removeAddress($id, Address $address, AddressRepository $repository, ObjectManager $manager)
    {
        $address = $repository->find($id);

        $manager->remove($address);
        $manager->flush();

        return $this->redirectToRoute('delivery');
    }

    /**
     * @Route("/panier/valider", name="validate")
     */
    public function validate()
    {
        return $this->render('frontend/cart/validate.html.twig');
    }
}
