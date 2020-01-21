<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\Mailer;
use App\Service\MailerSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerSender $mailerSender): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $mailerSender->sendContactMail($data);
            $this->addFlash("success", "Votre messaqe a bien été envoyé !");
            return $this->redirectToRoute('contact');
        }
        return $this->render("contact/index.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
