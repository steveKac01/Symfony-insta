<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ImageRepository;

class HomeController extends AbstractController
{
    #[route('/', 'home', methods: ['GET'])]
    public function index(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();

        return $this->render("home.html.twig",["images"=>$images]);
    }
}
