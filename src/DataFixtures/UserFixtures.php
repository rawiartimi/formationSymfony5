<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REF='user_ref' ;
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setFirstname('Rawia');
        $user1->setLastname("Rtimi");
        $user1->setPassword("123456789");
        $user1->setEmail("rtimi.rawia@gmail.com");
        $user1->setRoles("admin");
        $manager->persist($user1);
        $manager->flush();
        $this->addReference(self::USER_REF,$user1);
    }
}
