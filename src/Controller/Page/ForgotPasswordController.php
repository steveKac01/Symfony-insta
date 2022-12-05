<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot/password', name: 'user.forgot_password')]
    public function index(): Response
    {
        return $this->render('user/forgot_password.html.twig', [
            'controller_name' => 'ForgotPasswordController',
        ]);
    }
}
