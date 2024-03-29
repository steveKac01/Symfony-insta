<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * Log the user.
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: 'security.login', methods:['GET','POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        //If the user is already logged, redirects to homepage.
        if($this->getUser()!=null){
            return $this->redirectToRoute('home');
        }

        return $this->render('user/login.html.twig', [
            'lastUserName' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
}
