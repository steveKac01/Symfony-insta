<?php

namespace App\Controller\Page;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Email\emailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * This controller send a contact email & persist the message in the database.
     * If the user is connected, the email input is autofilled.
     * 
     * @param emailService $mailer
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/contact', name: 'contact')]
    public function index(emailService $mailer,  Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        if ($this->getUser()) {
            $contact->setEmail($this->getUser()->getUserIdentifier());
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
