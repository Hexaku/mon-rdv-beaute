<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class VerifyTokenMailer
{
    private $mailer;

    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendVerificationMail($data, $token): void
    {
        $mail = $data->getEmail();

        $email = (new Email())
            ->from($mail)
            ->to($mail)
            ->subject('Confirmation d\'inscription Mon RDV Beauté !')
            ->html($this->twig->render("registration/mail.html.twig", [
                "firstname" => $data->getFirstname(),
                "lien" => "http://127.0.0.1:8000/verify-email",
                "token" => $token,
            ]));

        $this->mailer->send($email);
    }
}
