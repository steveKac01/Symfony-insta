<?php

namespace App\Controller\Page;

use App\Repository\ImageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * List all posts, or search posts if the search form is filled.
     *
     * @param ImageRepository $imageRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param TranslatorInterface $translatorInterface
     * @return Response
     */
    #[route('/', 'home', methods: ['GET','POST'])]
    public function index(ImageRepository $imageRepository, PaginatorInterface $paginator, Request $request, TranslatorInterface $translatorInterface): Response
    {
        // Search form filled.
        if($request->get('search'))
        {
            
            $images = $paginator->paginate(
                $images = $imageRepository->searchPost($request->get('search')),
                $request->query->getInt('page', 1),
                10
            );

            return $this->render("pages/home.html.twig", ["images" => $images,"test"=> $translatorInterface->trans('Welcome')]);  
        }

        $images = $paginator->paginate(
            $imageRepository->findBy(array(), array('id' => 'DESC')),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("pages/home.html.twig", ["images" => $images,"test"=> $translatorInterface->trans('Welcome')]);
    }
}
