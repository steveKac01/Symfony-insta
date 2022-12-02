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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\Interface\FixturesInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface, FixturesInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {
        $post = [];
        //Post
        for ($i = 0; $i < $this->NUMBER_POST; $i++) {
            $image = new Image();
            $image->setTitle($this->faker->text(mt_rand(5, 50), true))
                ->setDescription($this->faker->text(mt_rand(5, 255), true))
                ->setCategory($this->getReference('category_'. mt_rand(0,count($this->CATEGORIES_LABEL)-1)))
                ->setUrl('https://via.placeholder.com/300')
                ->setUserImage($this->getReference('user_' . mt_rand(1, $this->NUMBER_USER)));

            array_push($post, $image);
            $manager->persist($image);
        }

        // Comments
        for ($i = 0; $i < $this->NUMBER_COMMENTS; $i++) {
            $comment = new Comment();
            $comment->setMessage($this->faker->text(mt_rand(5, 255), true))
                ->setImage($post[mt_rand(0, count($post) - 1)])
                ->setUserComment($this->getReference('user_' . mt_rand(1, $this->NUMBER_USER)));

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CategoryFixtures::class,
        );
    }
}
