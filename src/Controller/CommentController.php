<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index()
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("/comment/add", name="addComment") 
     
     */
    public function add(Request $request)
    {
        $comment = new Comment();
        $comment->setUser($this->getUser());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $comment->setCreatedAt(new \DateTime());
        // }

        return $this->render('comment/addedComment.html.twig', [
            'formAddedComment' => $form->createView(),
        ]);
    }
}
