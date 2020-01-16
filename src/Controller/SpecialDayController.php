<?php


namespace App\Controller;

use App\Entity\ContactDay;
use App\Form\ContactDayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpecialDayController extends AbstractController
{
    /**
     * @Route("special_day", name="special_day")
     */
    public function index(Request $request): Response
    {
        /* To get contacts details of people interested by a special_day,
send in special_day table*/
        $contactDay = new contactDay();
        $form = $this->createForm(contactDayType::class, $contactDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactDay);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render("special_day/index.html.twig", [
            "form" => $form->createView(),
            "contactDay" => $contactDay
        ]);
    }
}
