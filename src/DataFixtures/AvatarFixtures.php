<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Interface\FixturesInterface;

class AvatarFixtures extends Fixture implements FixturesInterface
{

    /**
     * Generate some avatars.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= $this::NUMBER_AVATAR; $i++) {
            $avatar = new Avatar();
            $avatar->setLabel('avatar_' . $i . '.jpg')
                ->setUrl('avatar_' . $i . '.jpg');
            $this->setReference('avatar_' . $i, $avatar);

            $manager->persist($avatar);
        }

        $manager->flush();
    }
}
