<?php

namespace App\Service\Email;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class emailServiceContact
{
    private $emailAdmin;
    private $mailer;

    public function __construct(string $admin_email, MailerInterface $mailer)
    {
        $this->emailAdmin = $admin_email;
        $this->mailer = $mailer;
    }

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
            ->to($this->emailAdmin)
            ->subject($contact->getSubject()?$contact->getSubject():'no subject')
            ->text($contact->getMessage())
            ->html('<p>'.$contact->getMessage().'</p>');

        $this->mailer->send($email);
    }
}
