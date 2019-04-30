<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    public function resultSearch()
    {
        // echo '<pre>';
        // var_dump($_GET["search"]);
        // echo '</pre>';
        // die();
        $search = $_GET["search"];
        // $curl = curl_init('https://www.googleapis.com/books/v1/volumes?q=php');
        $curl = curl_init('https://www.googleapis.com/books/v1/volumes?q=' . $search);

        // curl_setopt_array($curl, [
        //     CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer',
        //     CURLOPT_RETURNTRANSFER, true,
        // ]);

        curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            // var_dump(curl_error($curl));
            return null;
        } else {
            $results = [];
            $data = json_decode($data, true);
            // echo '<pre>';
            // var_dump($data);    
            // var_dump($data['items'][0]['volumeInfo']['title']);
            // echo '</pre>';

            foreach ($data['items'] as $book) {
                $results[] = [
                    'title'         => $book['volumeInfo']['title'],
                    'author'        => $book['volumeInfo']['authors'][0],
                    'publisher'     => $book['volumeInfo']['publisher'],
                    'publishedDate' => $book['volumeInfo']['publishedDate'],
                    'description'   => $book['volumeInfo']['description'],
                    'cover'         => $book['volumeInfo']['imageLinks']['smallThumbnail']
                ];
                // echo '<pre>';
                // var_dump($results);
                // die();
                // echo '</pre>';
            }
        }
        curl_close($curl);
        return $this->render('search/resultSearch.html.twig', array(
            'results' => $results 
        ));
    }
}
