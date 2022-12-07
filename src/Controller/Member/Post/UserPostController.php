<?php

namespace App\Controller\Member\Post;

use App\Repository\ImageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserPostController extends AbstractController
{
    
    #[route('member/post/show/', 'post.user', methods: ['GET'])]
    #[Security('is_granted("ROLE_USER")')]
    public function index(ImageRepository $imageRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $images = $paginator->paginate(
            $imageRepository->findBy(['userImage' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("user/posts.html.twig", ["images" => $images]);
    }
}
