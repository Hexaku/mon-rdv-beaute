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
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = (new Email())
                ->from('akuserukid@gmail.com')
                ->to('akuserukid@gmail.com')
                ->subject('Vous avez reçu un message depuis Mon RDV Beauté !')
                ->html($this->renderView("contact/mail.html.twig", [
                    "message" => $data["Message"],
                    "prenom" => $data["Prenom"],
                    "nom" => $data["Nom"],
                    "email" => $data["Email"],
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
