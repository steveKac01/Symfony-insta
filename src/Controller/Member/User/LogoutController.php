<?php

namespace App\Controller\Member\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This controller logout the user.
 */

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'security.logout')]
    public function logout()
    {
       /**
        * Complete for a custom logout.
        */
    }
}
