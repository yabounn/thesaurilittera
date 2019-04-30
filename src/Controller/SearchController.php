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
            'formSearch' => $form->createView(),
        ]);
    }

    /**
     * @Route("/resultSearch", name="resultSearch")
     */
    public function resultSearch(Request $request)
    {
        $curl = curl_init('https://www.googleapis.com/books/v1/volumes?q=' . $request->query->get('search'));

        // curl_setopt_array($curl, [
        //     CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer',
        //     CURLOPT_RETURNTRANSFER, true
        // ]);

        curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($curl);

        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return null;
        } else {
            $results = [];
            $data = json_decode($data, true);
            foreach ($data['items'] as $book) {
                $results[] = [
                    'title'         => $book['volumeInfo']['title'] ?? '', //?? '' Opérateur NUll coalescent
                    'author'        => $book['volumeInfo']['authors'][0] ?? '',
                    'publisher'     => $book['volumeInfo']['publisher'] ?? '',
                    'publishedDate' => $book['volumeInfo']['publishedDate'] ?? '',
                    'description'   => $book['volumeInfo']['description'] ?? '',
                    'cover'         => $book['volumeInfo']['imageLinks']['smallThumbnail'] ?? ''
                ];
            }
        }
        curl_close($curl);

        return $this->render('search/resultSearch.html.twig', array(
            'results' => $results 
        ));
    }
}
