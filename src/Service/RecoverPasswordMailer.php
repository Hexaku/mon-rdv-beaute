<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class RecoverPasswordMailer
{
    private $mailer;

    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendRecoverMail(array $data, string $token): void
    {
        $mail = $data["email"];

        $email = (new Email())
            ->from($mail)
            ->to($mail)
            ->subject('Oubli de mot de passe - Mon RDV Beauté')
            ->html($this->twig->render("recover-password/mail.html.twig", [
                "lien" => "http://127.0.0.1:8000/recover-password",
                "token" => $token,
            ]));

        $this->mailer->send($email);
    }
}
