<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Form\BookType;
use App\Entity\Book;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class BookController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository)
    {

    }
    #[Route('/book/{id}', name: 'app_book', methods: ['GET','POST'])]
    public function index( Request $request,EntityManagerInterface $em, BookRepository $bookRepository, $id): Response
    {
        $book = $bookRepository->find($id);
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($book);

            // $em->persist($book);
            // $em->flush();

            // $this->addFlash('success', 'Éditeur ajouté avec succès !');
        }

        $books = $this->bookRepository->findAll();
        //dd ($books);
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'view_exemple' => "Mon exemple de View !",
            'books' => $books,
            'form' => $form
        ]);
    }
}
