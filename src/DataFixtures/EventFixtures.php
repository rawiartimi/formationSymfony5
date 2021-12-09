<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Manager\EventManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function load(ObjectManager $manager): void
    {
        $event1 = $this->eventManager->createEventObject($this->getReference(UserFixtures::USER_REF));
        $event1->setName('dev web');
        $event1->setStartAt(new \DateTimeImmutable('now'));
        $event1->setOwner($this->getReference(UserFixtures::USER_REF));
        $event1->setAdress("Rue XXX Tunis");
        $manager->persist($event1);

        $event2 = $this->eventManager->createEventObject($this->getReference(UserFixtures::USER_REF));
        $event2->setName('dev java');
        $event2->setStartAt(new \DateTimeImmutable('now'));
        $event2->setAdress("Rue XXX Tunis");
        $manager->persist($event2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
