<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{


    public $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * 
     * @Route("","homepage", methods={"GET"})
     */
    public function index()
    {
        $events = $this->em->getRepository(Event::class)->findAll();

        return $this->render("home/index.html.twig",["events"=>$events]);
    }

}