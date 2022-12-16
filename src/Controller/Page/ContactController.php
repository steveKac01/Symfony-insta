<?php

namespace App\Controller\Page;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Email\emailServiceContact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ContactController extends AbstractController
{

    #[Route('/contact', name: 'contact')]
    public function index(emailServiceContact $mailer,  Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        if ($this->getUser()) {
            $contact->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Your message has been sucessfully sent !'
            );

            //Send an email
            $mailer->sendContact($contact);

           return $this->redirectToRoute('home');
        }

        return $this->render('pages/contact.html.twig', ['form' => $form->createView()]);
    }
}
