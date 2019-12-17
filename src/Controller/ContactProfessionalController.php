<?php

namespace App\Controller;

use App\Form\ContactProfessionalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactProfessionalController extends AbstractController
{
    /**
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
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
                    "prenom" => $data["prenom"],
                    "nom" => $data["nom"],
                    "email" => $data["email"],
                    "activite" => $data["activite"],
                    "lieu" => $data["lieu"],
                    "commentaire" => $data["commentaire"],
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
