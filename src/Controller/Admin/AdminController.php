<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Address;
use App\Form\AddressType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/user/all", name="admin_user_all")
     */
    public function all()
    {
        $users = $this->repository->findAll();

        return $this->render('admin/user/all.html.twig', [
            'users' => $users,

        ]);
    }

    /**
     * @Route("/admin/user/one", name="admin_user_one")
     */
    public function one()
    {
        return $this->render('admin/user/one.html.twig');
    }

    /**
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function edit($id, User $user, Request $request, ObjectManager $manager)
    {
        $user = $this->repository->find($id);
        // dump($user);
        // exit;
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('admin_user_all');
        }

        return $this->render('admin/user/edit.html.twig', [
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     */
    public function delete(User $user, ObjectManager $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé !');
        return $this->redirectToRoute('admin_user_all');
    }

    // Address user //

    /**
     * @Route("/admin/address/add/{id}", name="admin_address_add")
     */
    public function addAddress($id, User $user, Address $address = null, Request $request, ObjectManager $manager)
    {
        $address = new address();
        $user = $this->repository->find($id);
        // dump($user->getId());
        // exit;
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setCreatedAt(new \DateTime());

            $manager->persist($address);
            $manager->flush();

            return $this->redirectToRoute('admin_user_one');
        }

        return $this->render('admin/address/add.html.twig', [
            'formAddress' => $form->createView()
        ]);
    }
}
