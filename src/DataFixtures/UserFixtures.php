<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Interface\FixturesInterface;

class UserFixtures extends Fixture implements FixturesInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {
        //User with Admin role.
        $user = new User();
        $user->setEmail('steve@aol.fr')
            ->setpseudo('steve01')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('steve');
        $this->addReference('user_1', $user);

        $manager->persist($user);

        // random users
        for ($i = 2; $i < $this::NUMBER_USER + 1; $i++) {
            $user = new User();

            $user->setEmail($this->faker->email())
                ->setpseudo($this->faker->userName())
                ->setPlainPassword('password');

            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
