<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');

        $roles[] = 'ROLE_ADMIN';
        $roles[] = 'ROLE_USER';

        for($i = 0; $i < 5; ++$i) {

            $user = new User();

            $password = $this->hasher->hashPassword($user, '.Etml-44');

            $user
                ->setUsername($faker->userName())
                ->setPassword($password)
                ->setRoles($roles);
            $manager->persist($user);
        }

        $manager->flush();
    }
}