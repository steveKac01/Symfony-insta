<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Before each update or persist of the user entity
 * hash the plain password then set it in the user password property.
 */
class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function preUpdate(User $user): void
    {
        $this->encodePassword($user);
    }

    public function prePersist(User $user): void
    {
        $this->encodePassword($user);
    }

    /**
     * Hash the plain password.
     *
     * @param User $user
     * @return void
     */
    public function encodePassword(User $user): void
    {
        if ($user->getPlainPassword() === null) {
            return;
        }

        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlainPassword()
            )
        );

        $user->setPlainPassword(null);
    }
}
