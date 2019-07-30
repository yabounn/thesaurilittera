<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
     * @Route("/admin/author", name="author")
     */
    public function index()
    {
        return $this->render('admin/author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    /**
     * 
     *@Route("/admin/author/add", name="author_add")
     * @param Request $request
     * @return void
     */
    // public function add(Request $request)
    // {
    //     $author = new Author();

    //     $form = $this->createForm(AuthorType::class, $author);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($author);
    //         $em->flush();

    //         $this->addFlash('success', 'L\'auteur a été ajouté !');

    //         return $this->redirectToRoute('admin_book_add');
    //     }

    //     return $this->render('admin/author/add.html.twig', [
    //         'formAddedAuthor' => $form->createView()
    //     ]);
    // }
}
