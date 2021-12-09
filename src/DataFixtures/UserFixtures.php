<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public const USER_REF = 'user_ref' ;
    
    public function load(ObjectManager $manager): void
    {
        $plainPassword = "123456789";
        $user1 = new User();
        $user1->setFirstname('Ahmed');
        $user1->setLastname("Ghali");
        $user1->setPassword($this->passwordHasher->hashPassword($user1, $plainPassword));
        $user1->setEmail("ghaliano2005@gmail.com");
        $user1->setRoles(["ROLE_EVENT_MANAGER"]);
        $manager->persist($user1);
        $manager->flush();
        
        $user1 = new User();
        $user1->setFirstname('Ahmed');
        $user1->setLastname("Ghali");
        $user1->setPassword($this->passwordHasher->hashPassword($user1, $plainPassword));
        $user1->setEmail("ghaliano2005@gmail.com");
        $user1->setRoles(["ROLE_EVENT_MANAGER"]);
        $manager->persist($user1);
        $manager->flush();
        $this->addReference(self::USER_REF,$user1);
    }
}