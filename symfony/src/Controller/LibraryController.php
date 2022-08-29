<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class LibraryController extends AbstractController
{

    /**
    *@Route("/library/list", name= "library_list");
    */

    public function library_list(Request $request){

        $title = $request->get('title', 'Alegria');
//      this->logger->info('List action called');
        $response = new JsonResponse();
        $response->setData([
            'succes' => true,
            'data' =>[
                [
                    'id'=> 1,
                    'title' => 'Hola mundo'
                ],
                [
                    'id' => 2,
                    'title' => 'Libro 2'
                ],
                [
                    'id' => 3,
                    'title' => $title
                ]
            ]
        ]);

        return $response;
    }

}
