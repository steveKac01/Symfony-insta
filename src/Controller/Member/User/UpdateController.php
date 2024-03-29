<?php

namespace App\Controller\Member\User;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UpdateController extends AbstractController
{
    /**
     * Update the profile of the user.
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param User $userSelected
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    #[Security('is_granted("ROLE_USER") and user === userSelected')]
    #[route('/profil/{id}', 'user.update', methods: ['GET', 'POST'])]
    public function Update(Request $request, EntityManagerInterface $manager, User $userSelected, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserType::class, $userSelected);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($userSelected, $form->getData()->getPlainPassword())) {
                $userSelected = $form->getData();
                $userSelected->setUpdatedAt(new \DateTimeImmutable());                
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
