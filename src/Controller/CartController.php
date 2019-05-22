<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/{id}", name="cart")
     */
    public function index(User $user, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $cart = $user->getCart();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'id' => $id
        ]);
    }

    /**
     * @Route("/book/{id}/addedToCart", name="addedToCart")
     */
    public function addedToCart($id, UserInterface $userInt, UserRepository $user_repo, BookRepository $book_repo, ObjectManager $manager)
    {
        if ($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'))
            $userId = $userInt->getId();
        $userInfos = $user_repo->find($userId);

        $book = $book_repo->find($id);

        $cart = $userInfos->addCart($book);

        $manager->persist($cart);
        $manager->flush();

        return $this->redirectToRoute('cart', [
            'id' => $userId,
        ]);
    }

    /**
     * @Route("/book/{id}/remove", name="removeToCart")
     *
     */
    public function removeToCart($id, UserInterface $userInt, UserRepository $user_repo, BookRepository $book_repo, ObjectManager $manager)
    {
        $userId = $userInt->getId();
        $userInfos = $user_repo->find($userId);

        $book = $book_repo->find($id);

        $cart = $userInfos->removeCart($book);

        $manager->persist($cart);
        $manager->flush();

        return $this->redirectToRoute('cart', [
            'id' => $userId,
        ]);
    }
}
