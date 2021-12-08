<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{

    public $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(): Response
    {
        $events = $this->em->getRepository(Event::class)->findBy(['name'=> "dev java","owner"=>2]);

        return $this->render("home/index.html.twig",["events"=>$events]);
    }
    /**
     * @Route("/show/{id}", name="event_show")
     */
    public function show(int $id)
    {
        $event = $this->em->getRepository(Event::class)->find($id);
        return $this->render("event/show.html.twig",["event"=>$event]);
    }

}
