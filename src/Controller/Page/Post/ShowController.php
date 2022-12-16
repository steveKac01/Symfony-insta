<?php

namespace App\Controller\Page\Post;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * Show a post selected by his id with comments.
     * A form to create a commentary is provided.
     *
     * @param Post $post
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[route('posts/show/{id}', 'post.show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $comment = $form->getData();
            $comment->setImage($post);
            $comment->setUserComment($this->getUser());

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Your commentary has been posted successfully !');
        }

        return $this->render('pages/posts/show.html.twig', ['form' => $form->createView(), 'post' => $post]);
    }
}
