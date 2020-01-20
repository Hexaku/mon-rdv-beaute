<?php


namespace App\Controller;

use App\Entity\ContactDay;
use App\Entity\Pack;
use App\Form\ContactDayType;
use App\Repository\PackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/special_day")
 */
class SpecialDayController extends AbstractController
{
    /**
     * @Route("/", name="special_day", methods={"POST", "GET"})
     */
    public function index(Request $request, PackRepository $packRepository): Response
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
            "contactDay" => $contactDay,
            "packs" => $packRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{slug}", name="special_day_pack", methods={"POST", "GET"})
     */
    public function showPack(Request $request, Pack $pack): Response
    {
        /* To get contacts details of people interested by a special_day,
send in contact_day table*/
        $contactDay = new contactDay();
        $form = $this->createForm(contactDayType::class, $contactDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactDay);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render("special_day/show.html.twig", [
            "pack" => $pack,
            "form" => $form->createView(),
        ]);
    }
}
