<?php

namespace App\Controller\Page;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    /**
     * Register the user if the form is valided then redirect to the login page.
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[route('/register','user.register',methods:['GET','POST'])]
    public function Create(Request $request, EntityManagerInterface $manager) : Response
    {
        //If the user is already logged, redirect to homepage.
        if($this->getUser()!=null){
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success',
            'Account created, please log in.');

            return $this->redirectToRoute('security.login');
        }

        return $this->render('user\register.html.twig',['form' => $form->createView()]);
    }
}
