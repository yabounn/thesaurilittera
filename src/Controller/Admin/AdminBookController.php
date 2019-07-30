<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Category;

use App\Form\AddedBookType;
use App\Form\AuthorType;
use App\Form\CategoryType;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\AuthorRepository;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class AdminBookController extends AbstractController
{

    private $repository;
    private $authorRepository;
    private $categoryRepository;



    public function __construct(BookRepository $repository, AuthorRepository $authorRepository, CategoryRepository $categoryRepository)
    {
        $this->repository = $repository;
        $this->authorRepository = $authorRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/admin/book", name="admin_book_index")
     */
    public function index()
    {

        return $this->render('admin/book/index.html.twig', []);
    }

    /**
     * @Route("/admin/book/all", name="admin_book_all")
     */
    public function all()
    {
        $books = $this->repository->findAll();

        return $this->render('admin/book/all.html.twig', [
            'books' => $books
        ]);
    }

    /**
     *@Route("/admin/book/show/{id}", name="admin_book_show")
     */
    public function show($id, Book $book)
    {
        $book = $this->repository->find($id);

        return $this->render('admin/book/show.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * Permet de créér et  de modifier un livre
     * 
     * @Route("/admin/book/add", name="admin_book_add")
     * @Route("/admin/book/edit/{id}", name="admin_book_edit")
     */
    public function formBook(Book $book = null, Request $request, ObjectManager $manager)
    {
        if (!$book) {
            $book = new book();
        }

        $form = $this->createForm(AddedBookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('admin_book_all');
        }
        return $this->render('admin/book/add.html.twig', [
            'formBook' => $form->createView(),
            'editMode' => $book->getId() !== null
        ]);
    }

    /**
     * Supprimer un livre
     *
     * @Route("/admin/book/delete/{id}", name="admin_book_delete")
     */
    public function delete(Book $book, ObjectManager $manager)
    {
        $manager->remove($book);
        $manager->flush();

        $this->addFlash('success', 'Le livre a bien été supprimé !');

        return $this->redirectToRoute('admin_book_all');
    }


    //  Auteur //

    /**
     * @Route("/admin/author/list", name="admin_author_list")
     */
    public function listAuthor()
    {
        $authors = $this->authorRepository->findAll();

        return $this->render('admin/author/list.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * Permet d'ajouter un auteur
     * 
     *@Route("/admin/author/add", name="admin_author_add")
     * @param Request $request
     * @return void
     */
    public function addAuthor(Request $request)
    {
        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            $this->addFlash('success', 'L\'auteur a été ajouté !');

            return $this->redirectToRoute('admin_book_add');
        }
        return $this->render('admin/author/add.html.twig', [
            'formAddedAuthor' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/author/delete/{id}", name="admin_author_delete")
     */
    public function deleteAuthor(Author $author, ObjectManager $manager)
    {
        $manager->remove($author);
        $manager->flush();

        $this->addFlash('success', 'L\'auteur a bien été supprimé');
        return $this->redirectToRoute('admin_author_list');
    }


    // Catégories //

    /**
     * Liste l'ensemble des catégories
     * 
     * @Route("/admin/category/list", name="admin_category_list")
     */
    public function listCategory()
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category/add", name="admin_category_add")
     */
    public function addCategory(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie a été ajoutée !');

            return $this->redirectToRoute('admin_book_add');
        }
        return $this->render('admin/category/add.html.twig', [
            'formAddedCategory' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function deleteCategory(Category $category, ObjectManager $manager)
    {
        $manager->remove($category);
        $manager->flush();

        $this->addFlash('success', 'La catégorie a été supprimée');
        return $this->redirectToRoute('admin_category_list');
    }
}
