<?php

namespace App\Controller\Page\Post;

use App\Entity\User;
use App\Repository\ImageRepository;
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
     * @param ImageRepository $imageRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(User $user, ImageRepository $imageRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $images = $paginator->paginate(
            $imageRepository->findBy(['userImage' => $user],['id' => 'DESC']),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("user/posts.html.twig", ["images" => $images,"userList"=>$user->getpseudo()]);
    }
}
