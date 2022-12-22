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

    /**
     * Generate one admin user and some random users.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        //Random users.
        for ($i = 1; $i < $this::NUMBER_USER + 1; $i++) {
            $user = new User();

            $user->setEmail($this->faker->email())
                ->setpseudo($this->faker->userName())
                ->setPlainPassword('passwordValid01+')
                ->setAvatar('exemple'.mt_rand(1,4).'.jpg');

            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
