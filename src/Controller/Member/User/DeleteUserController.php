<?php

namespace App\Controller\Member\User;

use App\Entity\User;
use App\Form\DeleteAccountType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DeleteUserController extends AbstractController
{

    /**
     * This controller delete the user account if credentials are valide then redirect him to the homepage.
     *
     * @param TokenStorageInterface $token
     * @param UserPasswordHasherInterface $hasher
     * @param Request $request
     * @param User $userSelected
     * @param UserRepository $userRepository
     * @return Response
     */
    #[Security('is_granted("ROLE_USER") and user === userSelected')]
    #[route('delete/user/{id}/', 'user.delete', methods: ['GET', 'POST'])]
    public function delete(TokenStorageInterface $token, UserPasswordHasherInterface $hasher, Request $request, User $userSelected, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeleteAccountType::class, $userSelected);

        $form->handleRequest($request);
     

        if ($form->isSubmitted() && $form->isValid()) {

            if ($hasher->isPasswordValid($userSelected, $form->getData()->getPlainPassword())) {
                    
                    //Destroy the session before deleting the user.
                    $token->setToken(null);
                    $entityManager->remove($userSelected);
                    $entityManager->flush();

                return $this->redirectToRoute('home');

            } else {
                
                $this->addFlash('warning', 'Password or email invalid.');
            }
        }

        return $this->render('user/delete.html.twig', ["form" => $form->createView()]);
    }
}
