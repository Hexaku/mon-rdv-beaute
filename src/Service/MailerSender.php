<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerSender
{
    private $mailer;

    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendContactMail(array $data): void
    {
        $mail = $_ENV['MAILER_ADMIN'];

        $email = (new Email())
            ->from($mail)
            ->to($mail)
            ->subject('Vous avez reçu un message depuis Mon RDV Beauté !')
            ->html($this->twig->render("contact/mail.html.twig", [
                "message" => $data["message"],
                "firstName" => $data["firstName"],
                "lastName" => $data["lastName"],
                "email" => $data["email"],
            ]));

        $this->mailer->send($email);
    }
}
