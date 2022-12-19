<?php

namespace App\Service\Email;

use App\Entity\Contact;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class emailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send an email from the contact form.
     *
     * @param Contact $contact
     * @return void
     */
    public function sendContact(Contact $contact, string $emailContact): void
    {
            $this->mailer->send($this->createEmail(
                $contact->getEmail(),
                $emailContact,
                $contact->getSubject() ? $contact->getSubject() : 'no subject',
                $contact->getMessage(),
                '<p>' . $contact->getMessage() . '</p>'));      
    }

    /**
     * Send an email after a successfull registration.
     *
     * @param User $user
     * @return void
     */
    public function sendRegister(User $user)
    {
        $this->mailer->send($this->createEmail(
            'instapic@aol.fr',
            $user->getEmail(),
            'Welcome to instaPic !',
            'Hello ' . $user->getpseudo() . ' Thank you for registering to instaPic !',
            '<h1>Hello ' . $user->getpseudo() . '</h1> <p>Thank you for registering to instaPic !</p>'));
    }

    public function sendPassword(User $user)
    {
        //Todo
    }

    private function createEmail(string $from, string $to, string $subject, string $messageTxt, string $messageHtml): Email
    {
        return (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($messageTxt)
            ->html($messageHtml);
    }

}
