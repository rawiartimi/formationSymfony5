<?php

namespace App\Manager;

use App\Entity\Event;
use App\Entity\User;
use App\Event\EventCreatedEvent;
use App\Event\EventPublishedEvent;
use App\Event\EventRemovedEvent;
use App\Event\EventUpdatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventManager
{
    private $em;
    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
    }

    public function createEventObject(User $user)
    {
        $event = new Event();
        $event->setOwner($user);
        $event->setCreatedAt(new \DateTimeImmutable('now'));

        return $event;
    }

    public function createEvent(Event $event)
    {
        $this->em->persist($event);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EventCreatedEvent($event));
    }

    public function editEvent(Event $event)
    {
        $this->em->persist($event);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EventUpdatedEvent($event));
    }

    public function removeEvent(Event $event)
    {
        $this->em->remove($event);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EventRemovedEvent($event));
    }

    public function publishEvent(Event $event)
    {
        $this->em->remove($event);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EventPublishedEvent($event));
    }
}
