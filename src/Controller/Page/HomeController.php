<?php

namespace App\Controller\Page;

use App\Repository\ImageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[route('/', 'home', methods: ['GET'])]
    public function index(ImageRepository $imageRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $images = $paginator->paginate(
            $imageRepository->findBy(array(), array('id' => 'DESC')),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("pages/home.html.twig", ["images" => $images]);
    }
}
