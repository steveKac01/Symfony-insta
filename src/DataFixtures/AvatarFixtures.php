<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Interfaces\FixturesConfig;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AvatarFixtures extends Fixture implements FixturesConfig
{

    /**
     * Generate some avatars.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= count($this::AVATAR_LABEL); $i++) {
            $avatar = new Avatar();
            $avatar->setLabel($this::AVATAR_LABEL[$i-1])
                ->setUrl('avatar_' . $i . '.jpg');
            
            $this->setReference('avatar_' . $i, $avatar);

            $manager->persist($avatar);
        }

        $manager->flush();
    }
}
