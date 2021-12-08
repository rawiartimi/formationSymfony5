<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * 
     * @Route("home/")
     */
class HomeController extends AbstractController{

    /**
     * 
     * @Route( "index","index_acceuil", methods={"GET"})
     */
    public function index()
    {
        $events = [
            [
                'id' => 123,
                'name' => 'Evenement de formation',
                'createdAt' => '2021-10-10'
            ],
            [
                'id' => 124,
                'name' => 'Evenement Sportif',
                'createdAt' => '2021-10-10'
            ],
            [
                'id' => 12,
                'name' => 'Evenement musical',
                'createdAt' => '2021-10-10'
            ],
        ];

        return $this->render('home/index.html.twig', ["events" => $events, "version" => "5.4"]);

    }

}