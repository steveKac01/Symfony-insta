<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{

    #[route('/profil/{id}/password','user.changePassword',methods:['GET','POST'])]
    public function Update(Request $request, EntityManagerInterface $manager,User $user) : Response
    {
        
        if(!$this->getUser()){
           return $this->redirectToRoute('security.login');
        }

        if($user !== $this->getUser())
        {
            return $this->redirectToRoute('security.logout');
        }

        $form = $this->createForm(ChangePasswordType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();
            dd($user);
            $this->addFlash('success','Password updated !'); 
        }

        return $this->render('pages/user/change-password.html.twig',['form'=>$form->createView()]);
    }
}
