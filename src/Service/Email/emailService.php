<?php

namespace App\Service\Email;

use App\Entity\Contact;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class emailService
{
    private string $contactMail="contact@instapic.fr";
    private string $registerMail="do-no-reply@instapic.fr";
   
    public function __construct(private MailerInterface $mailer)
    {}

    /**
     * Send an email from the contact form.
     *
     * @param Contact $contact
     * @return void
     */
    public function sendContact(Contact $contact): void
    {
        $email = (new Email())
            ->from($contact->getEmail())
            ->to($this->contactMail)
            ->subject($contact->getSubject()?$contact->getSubject():'no subject')
            ->text($contact->getMessage());
        $this->mailer->send($email);
    }

    /**
     * Send an email after a successfull registration.
     *
     * @param User $user
     * @return void
     */
    public function sendRegister(User $user)
    {
        $email = (new Email())
        ->from($this->registerMail)
        ->to($user->getEmail())
        ->subject('Welcome to instaPic !')
        ->text('Hello '.$user->getpseudo().' Thank you for registering to instaPic !')
        ->html('<h1>Hello '.$user->getpseudo().'</h1> <p>Thank you for registering to instaPic !</p>');
        
        $this->mailer->send($email);
    }

}
