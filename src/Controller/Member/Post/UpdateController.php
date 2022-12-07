<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateController extends AbstractController
{
    #[route('member/image/update/{id}','image.update',methods:['GET','POST'])]
    #[Security("is_granted('ROLE_USER') and user === image.getUserImage()")]
    public function update(EntityManagerInterface $manager,Image $image,Request $request){

        $form = $this->createForm(ImageType::class,$image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $image = $form->getData();
            $manager->flush();

            $this->addFlash('success','Votre post a bien été modifié !');

            return $this->redirectToRoute('home',['_fragment' => $image->getId()]);
        }

        return $this->render('pages/posts/new-update.html.twig',['form'=>$form->createView(),'label'=>'update']);
    }

}
