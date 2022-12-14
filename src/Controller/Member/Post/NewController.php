<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewController extends AbstractController
{
    /**
     * Form to make a post.
     * If the form is valid:
     * Creates a post then redirects to the home with the id of the post.
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('member/image/new', 'image.new', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_USER")')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
         //il ne rentre pas dans l'image
            $image = $form->getData();
            $image->setUserImage($this->getUser());

            $manager->persist($image);
            $manager->flush();
            // dd($image); 
            return $this->redirectToRoute('home', ['_fragment' => $image->getId()]);
        }

        return $this->render('pages/posts/new-update.html.twig', ['form' => $form->createView(), 'label' => 'create']);
    }
}
