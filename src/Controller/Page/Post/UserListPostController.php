<?php

namespace App\Controller\Page\Post;

use App\Entity\User;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserListPostController extends AbstractController
{

    #[route('user/{id}/posts', 'post.user', methods: ['GET'])]
    /**
     * List the user posts with pagination.
     *
     * @param User $user
     * @param PostRepository $postRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(User $user, PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
            $postRepository->findBy(['userPost' => $user],['id' => 'DESC']),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("user/posts.html.twig", ["posts" => $posts,"userSelected"=>$user]);
    }
}
