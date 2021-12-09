<?php

namespace App\Event;

use App\Entity\Event  as EventEntity;
use Symfony\Contracts\EventDispatcher\Event;

class EventUpdatedEvent extends Event{
    private $event;
    public function __construct(EventEntity $event){
        $this->event = $event;
    }

    public function getEvent(): EventEntity{
        return $this->event;
    }
}