<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[route('member/image/update/{id}','image.update',methods:['GET','POST'])]
    public function update(EntityManagerInterface $manager,Image $image,Request $request){

        // If the post is not the user's one. delete this if i'm using voters.
        if($this->getUser()!== $image->getUserImage())
        {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(ImageType::class,$image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $image = $form->getData();
            $manager->persist($image);
            $manager->flush();

            $this->addFlash('success','Votre post a bien été modifié !');

            return $this->redirectToRoute('home',['_fragment' => $image->getId()]);
        }

        return $this->render('pages/images/new-update.html.twig',['form'=>$form->createView(),'label'=>'update']);
    }

}
