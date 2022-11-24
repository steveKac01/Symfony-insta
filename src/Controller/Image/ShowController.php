<?php

namespace App\Controller\Image;

use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController{
    
    #[route('image/show/{id}','image.show',methods:['GET'])]
    public function show(Image $image):Response
    {

        return $this->render('pages/images/show.html.twig',['image'=>$image]);
    }

}