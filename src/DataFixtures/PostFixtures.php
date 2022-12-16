<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Interface\FixturesInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface, FixturesInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    /**
     * Generate some random posts.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < $this::NUMBER_POST; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->text(mt_rand(5, 50), true))
                ->setDescription($this->faker->text(mt_rand(5, 255), true))
                ->setCategory($this->getReference('category_' . mt_rand(0, count($this::CATEGORIES_LABEL) - 1)))
                ->setUrl('exemple'.mt_rand(1,4).'.jpg')
                ->setUserPost($this->getReference('user_' . mt_rand(1, $this::NUMBER_USER)));

            $this->addReference('post_' . $i, $post);
            $manager->persist($post);
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
