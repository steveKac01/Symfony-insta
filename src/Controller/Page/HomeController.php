<?php

namespace App\Controller\Page;

use App\Interfaces\CacheConfig;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class HomeController extends AbstractController implements CacheConfig
{

    #[route('/', 'home', methods: ['GET', 'POST'])]
    public function index(PaginatorInterface $paginator, Request $request, PostRepository $postRepository): Response
    {

        // Search form filled
        if ($request->get('search')) {
            $posts = $postRepository->searchPost($request->get('search'));

            return $this->render("pages/search.html.twig", ["posts" => $posts]);
        }

        // Cache
        $cache = new FilesystemAdapter();
        $data = $cache->get($this::CACHE_POSTS_KEY, function (ItemInterface $item) use ($paginator, $postRepository, $request) {
            $item->expiresAfter(3600);
            return $postRepository->findBy(array(), array('id' => 'DESC'));
        });

        $posts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("pages/home.html.twig", ["posts" => $posts]);
    }
}
