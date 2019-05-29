<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('frontend/search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('frontend/search/search.html.twig', [
            'formSearch' => $form->createView()
        ]);
    }

    /**
     * @Route("/book/search", name="resultSearch")
     */
    public function resultSearch(Request $request, BookRepository $bookRepository)
    {
        $search = $request->query->get('search');
        // dump($search);
        $books = $bookRepository->findByTitle($search);
        // dump($books);

        return $this->render(
            'frontend/search/resultSearch.html.twig',
            [
                'search' => $search,
                'books' => $books
            ]
        );
    }
}
