<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {

        $pokemonImage = [
            'https://media.adeo.com/marketplace/MKP/85332304/6871abcd03fdad670e8b12481c8505bd.jpeg',
            'https://scarletviolet.pokemon.com/_images/pokemon/sprigatito/pokemon-sprigatito.png',
            'https://static.wikia.nocookie.net/ultimate-pokemon-fanon/images/7/7a/Grookey.png',
            'https://www.pokebip.com/images/2022/684.png',
            'https://www.jeuxvideo-live.com/wp-content/uploads/jvl/2022/09/crap-1.jpg',
            'https://scarletviolet.pokemon.com/_images/pokemon/smoliv/pokemon-smoliv.png',
            'https://www.media.pokekalos.fr/img/jeux/pev/tag-tag.jpg'
        ];

        $post =[];

        //Post
        for ($i = 0; $i < 20; $i++) {
            $image = new Image();
            $image->setTitle($this->faker->text(mt_rand(5, 50), true))
                ->setDescription($this->faker->text(mt_rand(5, 255), true))
                ->setUrl($pokemonImage[mt_rand(0, count($pokemonImage) - 1)]);
                array_push($post,$image);
                $manager->persist($image);
        }


        //Comments
        for ($i=0; $i < 70 ; $i++) { 
           
            $comment = new Comment();
            $comment->setMessage($this->faker->text(mt_rand(5, 255), true))
            ->setImage($post[mt_rand(0,count($post)-1)]);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
