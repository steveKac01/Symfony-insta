<?php

namespace App\Controller\Page;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[route('/', 'home', methods: ['GET', 'POST'])]
    public function index(PaginatorInterface $paginator, Request $request, PostRepository $postRepository): Response
    {

        // Search form filled
        if ($request->get('search')) {
            $posts = $postRepository->searchPost($request->get('search'));

            return $this->render("pages/search.html.twig", ["posts" => $posts]);
        }

        $posts = $paginator->paginate(
            $postRepository->findBy(array(), array('id' => 'DESC')),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("pages/home.html.twig", ["posts" => $posts]);
    }
}
