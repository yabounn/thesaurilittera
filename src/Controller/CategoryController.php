<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/category/add", name="addedCategory")
     */
    public function add(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em =$this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new Response('La catégorie a été ajoutée !');
        }

        // $formView = $form->createView();

        return $this->render('category/addedCategory.html.twig', [
            'formAddedCategory' => $form->createView()
        ]);
    }
}
