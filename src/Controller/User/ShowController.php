<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[route('/user','user.show',methods:['GET'])]
    public function Show(): Response
    {

        return $this->render('pages/user/profil.html.twig');
    }
}