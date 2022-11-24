<?php

namespace App\Controller\Image;

use App\Entity\Comment;
use App\Entity\Image;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{

    #[route('image/show/{id}', 'image.show', methods: ['GET', 'POST'])]
    public function show(Image $image, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            //Link the comment with the actual post.
            $comment->setImage($image);

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Votre commentaire a bien été posté');
        }

        return $this->render('pages/images/show.html.twig', ['form' => $form->createView(), 'image' => $image]);
    }
}
