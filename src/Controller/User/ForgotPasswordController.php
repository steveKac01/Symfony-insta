<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot/password', name: 'user.forgot_password')]
    public function index(): Response
    {
        return $this->render('forgot_password/index.html.twig', [
            'controller_name' => 'ForgotPasswordController',
        ]);
    }
}
