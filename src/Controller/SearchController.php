<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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

     
    public function search()
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('search/search.html.twig', [
            'formSearch' => $form->createView()
        ]);
    }

    /**
     * @Route("/resultSearch", name="resultSearch")
     */
    public function resultSearch()
    {

        
        return $this->render('search/resultSearch.html.twig');
    }

    
    
}
