<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Topic;
use App\Manager\EventManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    public $em;
    public $security;
    public $eventManager;

    public function __construct(EntityManagerInterface $entityManager, Security $security, EventManager $eventManager)
    {
        $this->em = $entityManager;
        $this->security = $security;
        $this->eventManager = $eventManager;
    }

    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(): Response
    {
        $events = $this->em->getRepository(Event::class)->findAll();

        return $this->render("home/index.html.twig", ["events" => $events]);
    }
    /**
     * @Route("/show/{id}", name="event_show")
     */
    public function show(int $id)
    {
        $event = $this->em->getRepository(Event::class)->find($id);
        return $this->render("event/show.html.twig", ["event" => $event]);
    }

    /**
     * need Authentication
     * @Route("/create", name="event_create")
     */
    public function create(Request $request)
    {
        $event = $this->eventManager->createEventObject($this->getUser());
        $form = $this
            ->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventManager->createEvent($event);
            return $this->redirectToRoute("event_index");
        }

        return $this->render('event/create.html.twig', [
            "form" => $form->createView()
        ]);
    }



    /**
     * need Authentication
     * @Route("/edit/{id}", name="event_edit")
     */
    public function edit(Request $request, Event $event)
    {
        $form = $this
            ->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventManager->editEvent($event);
            return $this->redirectToRoute("event_index");
        }

        return $this->render('event/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/list","event_list_paginate", methods={"GET"}, condition="request.headers.get('Accept') matches '/json/i'")
     */
    public function listPaginate(Request $request, SerializerInterface $serialezer)
    {
        $events = $this->em->getRepository(Event::class)->listEvents($request->get('page',0), 10);
        return new Response($serialezer->serialize($events, 'json'), 200, ['content-type' => "application/json"]);
    }
    /**
     * @Route("/list","event_list", methods={"GET"})
     */
    public function list(Request $request)
    {
        $events = $this->em->getRepository(Event::class)->listEvents(0, 10);

        return $this->render("event/list.html.twig", ["events" => $events]);
    }


}
