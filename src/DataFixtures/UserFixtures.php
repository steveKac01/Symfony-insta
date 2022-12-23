<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Interface\FixturesInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements FixturesInterface, DependentFixtureInterface 
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
        //User with Admin role.
        $user = new User();
        $user->setEmail('steve@aol.fr')
            ->setpseudo('steve01')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('steve')
            ->setAvatar($this->getReference('avatar_'. mt_rand(1,$this::NUMBER_AVATAR)));
        $this->addReference('user_1', $user);

        $manager->persist($user);

        //Random users.
        for ($i = 2; $i < $this::NUMBER_USER + 1; $i++) {
            $user = new User();

            $user->setEmail($this->faker->email())
                ->setpseudo($this->faker->userName())
                ->setPlainPassword('password')
                ->setAvatar($this->getReference('avatar_'. mt_rand(1,$this::NUMBER_AVATAR)));

            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return array(
            AvatarFixtures::class
        );
    }
}
