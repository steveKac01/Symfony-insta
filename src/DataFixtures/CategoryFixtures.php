<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Image;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Interface\FixturesInterface;

class CategoryFixtures extends Fixture implements FixturesInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {

        $categorie = new Category();

        for ($i = 0; $i < count($this->CATEGORIES_LABEL); $i++) {
            $categorie->setLabel($this->CATEGORIES_LABEL[$i])
                ->setDescription($this->faker->text(mt_rand(10, 250)))
                ->setColor($this->CATEGORIES_LABEL[$i]);
            $this->setReference('category_' . $i, $categorie);

            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
