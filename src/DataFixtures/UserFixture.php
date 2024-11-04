<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername("user$i");
            $user->setFirstName("firstName$i");
            $user->setLastname("lastName$i");
            $user->setEmail("user$i@gmail.com");
            $user->getRoles()[0] = "ROLE_USER";
            $user->setBio("Bio$i");
            $user->setPassword($this->passwordHasher->hashPassword($user, "user$i"));
            $user->setLastConnection(new DateTime());
            $manager->persist($user);
            $this->addReference("user-" . $i, $user);
        }
        $manager->flush();
    }
}
