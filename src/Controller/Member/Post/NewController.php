<?php

namespace App\Controller\Member\Post;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewController extends AbstractController
{
    /**
     * Form to make a post.
     * If the form is valid:
     * Creates a post then redirects to the home with the id of the post.
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Security('is_granted("ROLE_USER")')]
    #[Route('member/post/new', 'post.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post = $form->getData();
            $post->setUserPost($this->getUser());
            $entityManager->persist($post);
            $entityManager->flush();
            
            return $this->redirectToRoute('home', ['_fragment' => $post->getId()]);
        }

        return $this->render('pages/posts/new-update.html.twig', ['form' => $form->createView(), 'label' => 'Create']);
    }
}
