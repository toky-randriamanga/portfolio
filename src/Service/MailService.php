<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService 
{
    public function __construct(protected MailerInterface $mailer)
    {
        
    }

    /**
     * Envoi d'un mail
     */
    public function send(string $from, string $to, string $subject, string $content): bool
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($content)
            ->html($content);

        try {
            $this->mailer->send($email);

            return true;
        } catch(TransportExceptionInterface) {
            return false;
        }
    }
}