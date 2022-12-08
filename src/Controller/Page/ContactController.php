<?php

namespace App\Controller\Page;

use App\Form\ContactType;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//todo: Créer un service pour le mail !
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $headers = 'From: ' . $data['email'] . '' . "\r\n";
                mail('kaci.steve@k-net.fr', 'A message from instakilo', $data['message'], $headers);

                $this->addFlash(
                    'success',
                    'Votre message a bien été envoyé !'
                );

                return $this->redirectToRoute('home');
                
            } catch (Error $er) {
                $this->addFlash(
                    'error',
                    'Une erreur est survenue : ' . $er
                );
            }
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
