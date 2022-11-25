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


class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];

        //Admin
        $user = new User();
        $user->setEmail('steve@aol.fr')
            ->setpseudo('steve01')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('steve');

        array_push($users, $user);
        $manager->persist($user);

        //random users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email())
                ->setpseudo($this->faker->userName())
                ->setPlainPassword('password');

            array_push($users, $user);
            $manager->persist($user);
        }


        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categorie = new Category();
            $categorie->setLabel('GENERATION ' . ($i + 1))
                ->setDescription($this->faker->text(mt_rand(10, 250)));
            array_push($categories, $categorie);

            $manager->persist($categorie);
        }

        $post = [];
        //Post
        for ($i = 0; $i < 20; $i++) {
            $image = new Image();
            $image->setTitle($this->faker->text(mt_rand(5, 50), true))
                ->setDescription($this->faker->text(mt_rand(5, 255), true))
                ->setCategory($categories[mt_rand(0, count($categories) - 1)])
                ->setUrl('https://via.placeholder.com/300')
                ->setUserImage($users[mt_rand(0, count($users) - 1)]);

            array_push($post, $image);
            $manager->persist($image);
        }

        //Comments
        for ($i = 0; $i < 70; $i++) {
            $comment = new Comment();
            $comment->setMessage($this->faker->text(mt_rand(5, 255), true))
                ->setImage($post[mt_rand(0, count($post) - 1)])
                ->setUserComment($users[mt_rand(0, count($users) - 1)]);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
