<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewController extends AbstractController
{
    #[Route('image/new','image.new',methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager):Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class,$image);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $image= $form->getData();

            $manager->persist($image);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre image a été uploadé avec succès !'
            );

           return $this->redirectToRoute('home',['_fragment' => $image->getId()]);
        }

        return $this->render('pages/images/new-update.html.twig',['form' => $form->createView(),'label'=>'create']);
    }
}
