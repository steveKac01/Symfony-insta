<?php

namespace App\Controller\Page;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    #[route('/register','user.register',methods:['GET','POST'])]
    public function Create(Request $request, EntityManagerInterface $manager) : Response
    {
        //If the user is already logged.
        if($this->getUser()!=null){
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //create the user & insert in database.
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success',
            'Account created, please log in.');

            return $this->redirectToRoute('security.login');
        }

        return $this->render('pages\user\register.html.twig',['form' => $form->createView()]);
    }

}