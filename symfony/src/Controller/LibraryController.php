<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

class LibraryController extends AbstractController
{

    /**
     *@Route("/books", name= "book_get");
     */

    public function library_list(Request $request, BookRepository  $bookRepository){

//      this->logger->info('List action called');
        $books = $bookRepository->findAll();
        $booksAsArray=[];
        foreach($books as $book){
            $booksAsArray[]= [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'image' => $book->getImage()
            ];
        };
        $response = new JsonResponse();
        $response->setData([
            'succes' => true,
            'data' => $booksAsArray
        ]);

        return $response;
    }

    /**
     * @Route("/book/create", name="create_book");
     */

    public function createBook(Request $request, EntityManagerInterface $em){

        $book = new Book();
        $title= $request->get('title',null);
        $response = new JsonResponse();
        if(empty($title)){
            $response->setData([
                'succes' => false,
                'error' => 'El titulo no puede ir vacio',
                'data' => null
            ]);
            return $response;
        }
        $book->setTitle($title);
        $em->persist($book);
        $em->flush();
        $response->setData([
            'succes' => true,
            'data' =>[
                [
                    'id'=> $book->getId(),
                    'title' => $book->getTitle()
                ]
            ]
        ]);
        return $response;
    }
}
