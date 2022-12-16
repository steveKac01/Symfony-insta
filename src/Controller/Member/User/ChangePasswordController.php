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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ChangePasswordController extends AbstractController
{
    /**
     * Modify user password.
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param User $userSelected
     * @return Response
     */
    #[Security('is_granted("ROLE_USER") and user === userSelected')]
    #[route('/profil/{id}/password', 'user.changePassword', methods: ['GET', 'POST'])]
    public function Update(Request $request, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasher, User $userSelected): Response
    {
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userPasswordHasher->isPasswordValid($userSelected, $form->getData()['plainPassword'])) {

                $userSelected->setUpdatedAt(new \DateTimeImmutable());
                $userSelected->setPlainPassword($form->getData()['newPassword']);
                $entityManagerInterface->flush();

                $this->addFlash('success', 'Password updated !');
                return $this->redirectToRoute('home');

            } else {

                $this->addFlash('warning', 'Password incorrect !');
            }
        }

        return $this->render('user/change-password.html.twig', ['form' => $form->createView()]);
    }
}
