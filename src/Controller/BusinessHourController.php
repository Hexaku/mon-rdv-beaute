<?php

namespace App\Controller;

use App\Entity\BusinessHour;
use App\Form\BusinessHourType;
use App\Repository\BusinessHourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/business/hour")
 */
class BusinessHourController extends AbstractController
{
    /**
     * @Route("/", name="business_hour_index", methods={"GET"})
     */
    public function index(BusinessHourRepository $businessHourRepository): Response
    {
        return $this->render('business_hour/index.html.twig', [
            'business_hours' => $businessHourRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="business_hour_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $businessHour = new BusinessHour();
        $form = $this->createForm(BusinessHourType::class, $businessHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($businessHour);
            $entityManager->flush();

            return $this->redirectToRoute('business_hour_index');
        }

        return $this->render('business_hour/new.html.twig', [
            'business_hour' => $businessHour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="business_hour_show", methods={"GET"})
     */
    public function show(BusinessHour $businessHour): Response
    {
        return $this->render('business_hour/show.html.twig', [
            'business_hour' => $businessHour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="business_hour_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BusinessHour $businessHour): Response
    {
        $form = $this->createForm(BusinessHourType::class, $businessHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('business_hour_index');
        }

        return $this->render('business_hour/edit.html.twig', [
            'business_hour' => $businessHour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="business_hour_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BusinessHour $businessHour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$businessHour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($businessHour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('business_hour_index');
    }
}
