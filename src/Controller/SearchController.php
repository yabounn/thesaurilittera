<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar(Request $request)
    {
        $form = $this->createFormBuilder()
                    -> add ('rechercher')
                    // ->add('rechercher', SearchType::class, [
                    //     'attr' => ['placeholder' => "Rechercher"
                    //     ]
                    // ])
                    // ->add('ok', SubmitType::class, [
                    //     'attr' => ['class' => "btn btn-primary"
                    //     ]    
                    // ])
                    ->getForm();

        $form->handleRequest($request);            

        return $this->render('search/searchBar.html.twig', [
            'formSearch' => $form->createView()
        ]);
    }
}
