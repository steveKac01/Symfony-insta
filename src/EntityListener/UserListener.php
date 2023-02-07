<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\Email\emailService;

/**
 * Before each update or persist of the user entity
 * hash the plain password then set it in the user password property.
 */
class UserListener
{
    public function __construct(private UserPasswordHasherInterface $hasher, private emailService $mailer)
    {}

    public function preUpdate(User $user): void
    {
        $this->encodePassword($user);
    }

    public function prePersist(User $user): void
    {
        $this->encodePassword($user);
    }

    /**
     * Sends a mail after the user is successfully registered.
     *
     * @param User $user
     * @return void
     */
    public function postPersist(User $user): void
    {
        $this->mailer->sendRegister($user);
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
