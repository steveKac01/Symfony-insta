<?php

namespace App\Controller\Member\User;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[route('/profil/{id}', 'user.update', methods: ['GET', 'POST'])]
    public function Update(Request $request, EntityManagerInterface $manager, User $user, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('security.logout');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $user->setUpdatedAt(new \DateTimeImmutable());
                $manager->flush();

                $this->addFlash('success', 'Profile successfully updated !');

                return $this->redirectToRoute('home');

            } else {
                $this->addFlash('warning', 'Password incorrect !');
            }
        }

        return $this->render('user/profil.html.twig', ['form' => $form->createView()]);
    }
}
