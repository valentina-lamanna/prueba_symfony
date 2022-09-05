<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class LibraryController extends AbstractController
{

    /**
     *@Route("/book", name= "book_get");
     */

    public function book_list(Request $request, BookRepository  $bookRepository){

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
     * @Route("/book/post/create", name="create_book", methods={"POST"});
     */

    public function createBook(Request $request, EntityManagerInterface $em){


        $book = new Book();
        $request = json_decode($request->getcontent(), true);
        var_dump($request);
        $title= $request['title'];
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

    /**
     * @Route("/book/{id}", name="book_get_id");
     */

    public function  get_book_by_id(BookRepository  $bookRepository, int $id){
        $book= $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }
        $response= new JsonResponse();
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

    /**
     * @Route("/book/edit/{id}", name="book_update");
     */
    public function update(EntityManagerInterface $em, int $id, BookRepository  $bookRepository , Request $request){

        $book= $bookRepository->find($id);
        if(!$book){
            throw $this->createNotFoundException(
                'Not book was found for id '. $id
            );
        }
        $response = new JsonResponse();
        $title =$request->get('title');
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
                    'id'=> $book->getId(),// $id
                    'title' => $book->getTitle()
                ]
            ]
        ]);
        return $response;

    }
    /**
     * @Route("/book/delete/{id}", name="book_update");
     */
    public function delete(EntityManagerInterface $em, int $id, BookRepository  $bookRepository){

        $book= $bookRepository->find($id);
        if(!$book){
            throw $this->createNotFoundException(
                'Not book was found for id '. $id
            );
        }
        $response = new JsonResponse();



        $em->remuve($book);
        $em->flush();

        $response->setData([
            'succes' => true,
            'data' =>['se elimino correctamnete el libro con id '. $id]
        ]);
        return $response;

    }
}
