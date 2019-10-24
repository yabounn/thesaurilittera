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
            $this->addFlash('success', 'La quantité a été modifié avec succès !');
        } else {
            if ($request->query->get('quantity') != null) {
                $cartShopping[$id] = $request->query->get('quantity');
            } else {
                $cartShopping[$id] = 1;

                $this->addFlash('success', 'Le livre a été ajouté avec succès !');
            }
        }
        $session->set('cartShopping', $cartShopping);

        return $this->redirectToRoute('cart', [
            'cartShopping' => $cartShopping,
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
    public function delivery(Request $request, ObjectManager $manager, SessionInterface $session, BookRepository $repository)
    {
        $user = $this->getUser();
        $address = new Address();
        $books = $repository->findArray(array_keys($session->get('cartShopping')));


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
            'user' => $user,
            'books' => $books,
            'cartShopping' => $session->get('cartShopping')

        ]);
    }

    /**
     * @Route("/livraison/adresse/modifier/{id}", name="modifyAddressDelivery")
     */
    public function updateAddress(Request $request, Address $address, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setCreatedAt(new \DateTime());
            $address->setUser($user);
            $manager->persist($address);
            $manager->flush();

            return $this->redirectToRoute('delivery');
        }
        return $this->render('frontend/cart/address.html.twig', [
            'formAddress' => $form->createView()
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


    public function setDeliveryOnSession(Request $request, SessionInterface $session)
    {
        if (!$session->has('address')) $session->set('address', []);
        $address = $session->get('address');

        if ($request->get('delivery') != null && $request->get('facturation') != null) {
            $address['delivery'] = $request->get('delivery');
            $address['facturation'] = $request->get('facturation');
            // if ($request->get('delivery') != null) {
            //     $address['delivery'] = $request->get('delivery');
        } else {
            return $this->redirectToRoute('validate');
        }

        $session->set('address', $address);
        return $this->redirectToRoute('validate');
    }

    /**
     * @Route("/panier/valider", name="validate")
     */
    public function validate(Request $request, SessionInterface $session, BookRepository $bookRepository, AddressRepository $repository)
    {
        $this->setDeliveryOnSession($request, $session, $repository, $bookRepository);

        $session = $request->getSession();
        $address = $session->get('address');

        $books = $bookRepository->findArray(array_keys($session->get('cartShopping')));
        $delivery = $repository->find($address['delivery']);
        $facturation = $repository->find($address['facturation']);

        return $this->render('frontend/cart/validate.html.twig', [
            'books' => $books,
            'delivery' => $delivery,
            'facturation' => $facturation,
            'cartShopping' => $session->get('cartShopping')
        ]);
    }
}
