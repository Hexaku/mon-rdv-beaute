<?php

namespace App\Service;

use App\Entity\Booking;
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

    public function recapMail(Booking $booking): void
    {
        $mail = $_ENV['MAILER_ADMIN'];

        $email = (new Email())
            ->from($mail)
            ->to($mail)
            ->subject('Un utilisateur a réservé une prestation !')
            ->html($this->twig->render("booking/mail.html.twig", [
                'booking' => $booking,
            ]));

        $this->mailer->send($email);
    }

    public function recapMailClient(Booking $booking, $email): void
    {
        $mail = $_ENV['MAILER_ADMIN'];

        $email = (new Email())
            ->from($mail)
            ->to($mail)
            ->subject('Récapitulatif de votre réservation !')
            ->html($this->twig->render("booking/mail.html.twig", [
                'booking' => $booking,
            ]));

        $this->mailer->send($email);
    }

    public function sendProContactMail(array $data): void
    {
        $mail = $_ENV['MAILER_ADMIN'];
        $email = (new Email())
            ->from($mail)
            ->to($mail)
            ->subject('Un professionel souhaite rejoindre Mon RDV Beauté !')
            ->html($this->twig->render("contact-professional/mail.html.twig", [
                "firstName" => $data["firstName"],
                "lastName" => $data["lastName"],
                "email" => $data["email"],
                "profession" => $data["profession"],
                "city" => $data["city"],
                "commentary" => $data["commentary"],
            ]));

        $this->mailer->send($email);
    }
}
