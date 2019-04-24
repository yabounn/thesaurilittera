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

    public function searchBar()
    {
        // $form = $this->createFormBuilder()
        //             -> add ('rechercher')
        //             ->getForm();

        $form = $this->createForm(SearchType::class);

        return $this->render('search/searchBar.html.twig', [
            'formSearch' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request)
    {
        var_dump($request->request);
        die();
    }
}
