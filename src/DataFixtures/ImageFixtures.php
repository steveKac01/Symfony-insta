<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $image = new Image();
            $image->setTitle("Image #" . $i + 1)
                ->setDescription("Une description de l'image.")
                ->setUrl("https://media.adeo.com/marketplace/MKP/85332304/6871abcd03fdad670e8b12481c8505bd.jpeg");
            $manager->persist($image);
        }

        $manager->flush();
    }
}
