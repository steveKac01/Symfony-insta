<?php

namespace App\Controller\Member\Post;

use App\Entity\Post;
use App\Form\PostEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateController extends AbstractController
{
    /**
     * If the form is valid, updates a post in the database 
     * then redirect to he home with the id of the comment.
     * 
     * @param EntityManagerInterface $manager
     * @param Post $post
     * @param Request $request
     * @return void
     */
    #[route('member/update/post/{id}', 'post.update', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === post.getUserPost()")]
    public function update(EntityManagerInterface $manager, Post $post, Request $request)
    {

        $form = $this->createForm(PostEditType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $manager->flush();

            $this->addFlash('success', 'Votre post a bien été modifié !');

            return $this->redirectToRoute('home', ['_fragment' => $post->getId()]);
        }

        return $this->render('pages/posts/new-update.html.twig', ['form' => $form->createView(), 'label' => 'update']);
    }
}
