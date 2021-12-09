<?php

namespace App\Subscriber;

use App\Event\EventCreatedEvent;
use App\Event\EventPublishedEvent;
use App\Event\EventRemovedEvent;
use App\Event\EventUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EventEmailNotficationSubscriber implements EventSubscriberInterface
{
    public function __construct(private MailerInterface $mailer){

    }

    public static function getSubscribedEvents() : array
    {
        return [
            EventCreatedEvent::class => 'handleCreatedEvent',
            EventUpdatedEvent::class => 'handleUpdatedEvent',
            EventRemovedEvent::class => 'handleRemovedEvent',
            EventPublishedEvent::class => 'handlePublishEvent',
        ];
    }

    public function handleCreatedEvent(EventCreatedEvent $event){
        //Traitement d'envoi d'email à l'administrateur
        //admin@meetup-clone.com

        $email = (new Email())
        ->from("admin@meetup-clone.com")
        ->to("admin@meetup-clone.com")
        ->subject("Un nouveau évenement vient d'être ajouté")
        ->text(sprintf("Evenement avec comme titre %s a été ajouté sur la platforme", $event->getEvent()->getName()));
    
        $this->mailer->send($email);
    }

    public function handleUpdatedEvent(EventUpdatedEvent $event){
    }

    public function handleRemovedEvent(EventRemovedEvent $event){
    }

    public function handlePublishEvent(EventPublishedEvent $event){
        //Envoi d'email au proprietaire de l'évenement

        $email = (new Email())
        ->from("admin@meetup-clone.com")
        ->to($event->getEvent()->getOwner()->getEmail())
        ->subject("Votre évenement vient d'être approuvé")
        ->text(sprintf("Votre evenement avec comme titre %s a été approuvé sur la platforme", $event->getEvent()->getName()));
    
        $this->mailer->send($email);
    }
}