<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;

class ImageFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $image = new Image();
            $image->setTitle($this->faker->text(mt_rand(5, 50), true))
                ->setDescription($this->faker->text(mt_rand(5, 255), true))
                ->setUrl("https://media.adeo.com/marketplace/MKP/85332304/6871abcd03fdad670e8b12481c8505bd.jpeg");
            $manager->persist($image);
        }

        $manager->flush();
    }
}
