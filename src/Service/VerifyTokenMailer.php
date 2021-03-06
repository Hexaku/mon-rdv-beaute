<?php

namespace App\Service;

use App\Entity\User;
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

    public function sendVerificationMail(User $data, string $token): void
    {
        $mail = $data->getEmail();
        $firstName = $data->getFirstname();
        if ($mail) {
            $email = (new Email())
                ->from($mail)
                ->to($mail)
                ->subject('Confirmation d\'inscription - Mon RDV Beauté ')
                ->html($this->twig->render("registration/mail.html.twig", [
                    "firstname" => $firstName,
                    "token" => $token,
                ]));

            $this->mailer->send($email);
        }
    }
}
