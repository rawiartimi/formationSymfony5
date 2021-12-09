<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Topic;

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
        $events = $this->em->getRepository(Event::class)->findAll();

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

    /**
     * @Route("/create", name="event_create")
     */
    public function create(Request $request)
    {
        $event = new Event();
        $event->setCreatedAt(new DateTimeImmutable('now'));
        $form = $this
        ->createFormBuilder($event)
        ->add('name', TextType::class)
        ->add('startAt', DateTimeType::class, array(
            'input' => 'datetime_immutable',
        ))
        ->add('endAt', DateTimeType::class, array(
            'input' => 'datetime_immutable',
        ))
        ->add('adress', TextareaType::class)
        ->add('owner', EntityType::class,['class'=>User::class])
        ->add('topics', EntityType::class,['class'=>Topic::class,'multiple'=> true,'expanded'=> true])
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $this->em->persist($event);
            $this->em->flush();
            return $this->redirectToRoute("event_index");

        }
        return $this->render('event/create.html.twig', ["form" => $form->createView()]);
    }

}
