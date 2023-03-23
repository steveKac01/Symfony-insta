<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Comment;
use App\Interfaces\FixturesConfig;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentsFixtures extends Fixture implements DependentFixtureInterface, FixturesConfig
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    /**
     * Generate some random comments.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < $this::NUMBER_COMMENTS; $i++) {
            $comment = new Comment();
            $comment->setMessage($this->faker->text(mt_rand(5, 255)))
                ->setImage($this->getReference('post_' . mt_rand(0, $this::NUMBER_POST - 1)))
                ->setUserComment($this->getReference('user_' . mt_rand(1, $this::NUMBER_USER)));

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            PostFixtures::class,
        );
    }
}
