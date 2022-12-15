<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use App\Form\ImageEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateController extends AbstractController
{
    /**
     * If the form is valid, updates a post in the database 
     * then redirect to he home with the id of the comment.
     * 
     * @param EntityManagerInterface $manager
     * @param Image $image
     * @param Request $request
     * @return void
     */
    #[route('member/image/update/{id}', 'image.update', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === image.getUserImage()")]
    public function update(EntityManagerInterface $manager, Image $image, Request $request)
    {

        $form = $this->createForm(ImageEditType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->getData();
            $manager->flush();

            $this->addFlash('success', 'Votre post a bien été modifié !');

            return $this->redirectToRoute('home', ['_fragment' => $image->getId()]);
        }

        return $this->render('pages/posts/new-update.html.twig', ['form' => $form->createView(), 'label' => 'update']);
    }
}
