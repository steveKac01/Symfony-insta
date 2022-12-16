<?php

namespace App\Controller\Member\Post;

use App\Entity\Post;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * Delete a post then redirect the user to the homepage with a flash message.
     *
     * @param Post $post
     * @param PostRepository $postRepository
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user === post.getUserPost()")]
    #[route('member/delete/post/{id}', 'post.delete', methods: ['GET'])]
    public function delete(Post $post, PostRepository $postRepository): Response
    {
       $postRepository->remove($post, true);

        $this->addFlash(
            'success',
            'Your post has been successfully deleted !'
        );

        return $this->redirectToRoute('home');
    }
}
