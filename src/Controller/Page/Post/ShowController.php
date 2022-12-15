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
     * A form to create comment is provided.
     *
     * @param Post $post
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[route('posts/show/{id}', 'post.show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setImage($post);
            $comment->setUserComment($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Your commentary has been post successfully !');
        }

        return $this->render('pages/posts/show.html.twig', ['form' => $form->createView(), 'post' => $post]);
    }
}
