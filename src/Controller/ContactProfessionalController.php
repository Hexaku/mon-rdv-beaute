<?php

namespace App\Controller;

use App\Form\ContactProfessionalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactProfessionalController extends AbstractController
{
    /**
     * @Route("/contact-professional", name="contact_professional")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactProfessionalType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = (new Email())
                ->from('akuserukid@gmail.com')
                ->to('akuserukid@gmail.com')
                ->subject('Un professionel souhaite rejoindre Mon RDV Beauté !')
                ->html($this->renderView("contact-professional/mail.html.twig", [
                    "firstName" => $data["firstName"],
                    "lastName" => $data["lastName"],
                    "email" => $data["email"],
                    "profession" => $data["profession"],
                    "city" => $data["city"],
                    "commentary" => $data["commentary"],
                ]));

            $mailer->send($email);

            $this->addFlash("success", "Votre demande a bien été envoyé !");

            return $this->redirectToRoute('contact_professional');
        }

        return $this->render("contact-professional/index.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
