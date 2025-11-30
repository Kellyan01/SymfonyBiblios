<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;

final class BookController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository)
    {

    }
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        $books = $this->bookRepository->findAll();
        //dd ($books);
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'view_exemple' => "Mon exemple de View !",
            'books' => $books
        ]);
    }
}
