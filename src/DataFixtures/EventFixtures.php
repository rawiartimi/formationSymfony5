<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $event1 = new Event();
        $event1->setName('dev web');
        $event1->setStartAt(new \DateTimeImmutable('now'));
        $event1->setCreatedAt(new \DateTimeImmutable('now'));
        $event1->setOwner($this->getReference(UserFixtures::USER_REF));
        $event1->setAdress("Rue XXX Tunis");
        $manager->persist($event1);

        $event2 = new Event();
        $event2->setName('dev java');
        $event2->setStartAt(new \DateTimeImmutable('now'));
        $event2->setCreatedAt(new \DateTimeImmutable('now'));
        $event2->setAdress("Rue XXX Tunis");
        $event2->setOwner($this->getReference(UserFixtures::USER_REF));
        $manager->persist($event2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
