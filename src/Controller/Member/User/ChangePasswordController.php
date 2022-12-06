<?php

namespace App\Controller\Member\User;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    #[route('/profil/{id}/password', 'user.changePassword', methods: ['GET', 'POST'])]
    public function Update(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher, User $user): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('security.logout');
        }

        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userPasswordHasher->isPasswordValid($user, $form->getData()['plainPassword'])) {

                $user->setUpdatedAt(new \DateTimeImmutable());
                $user->setPlainPassword($form->getData()['newPassword']);
              
                $manager->flush();

                $this->addFlash('success', 'Password updated !');
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('warning', 'Password incorrect !');
            }
        }

        return $this->render('user/change-password.html.twig', ['form' => $form->createView()]);
    }
}
