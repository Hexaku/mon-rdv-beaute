<?php


namespace App\Controller;

use App\Entity\ContactSpeDay;
use App\Form\ContactSpeDayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="home", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        /** To get contacts details of people interested by a special_day,
        send in special_day table*/
        $contactSpeDay = new ContactSpeDay();
        $form = $this->createForm(ContactSpeDayType::class, $contactSpeDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactSpeDay);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render("home/index.html.twig", [
            'form' => $form->createView(),
            'contactSpeDay' => $contactSpeDay
        ]);
    }
}
