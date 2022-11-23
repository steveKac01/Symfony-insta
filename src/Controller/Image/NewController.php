<?php

namespace App\Controller\Image;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewController extends AbstractController
{
    #[Route('images/new','image.new',methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager):Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class,$image);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $image= $form->getData();

            $manager->persist($image);
            $manager->flush();

           return $this->redirectToRoute('home');
        }

        return $this->render('pages/images/new.html.twig',['form' => $form->createView()]);
    }
}
