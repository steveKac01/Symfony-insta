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
    #[route('/', 'home', methods: ['GET','POST'])]
    public function index(ImageRepository $imageRepository, PaginatorInterface $paginator, Request $request, TranslatorInterface $translatorInterface): Response
    {
        //Search bar
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
