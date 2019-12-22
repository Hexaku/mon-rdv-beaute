<?php


namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = (new Email())
                ->from('designebenjamin@gmail.com')
                ->to('designebenjamin@gmail.com')
                ->subject('Vous avez reçu un message depuis Mon RDV Beauté !')
                ->html($this->renderView("contact/mail.html.twig", [
                    "firstName" => $data["firstName"],
                    "lastName" => $data["lastName"],
                    "message" => $data["message"],
                    "email" => $data["email"],
                ]));

            $mailer->send($email);

            $this->addFlash("success", "Votre messaqe a bien été envoyé !");

            return $this->redirectToRoute('contact');
        }

        return $this->render("contact/index.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
