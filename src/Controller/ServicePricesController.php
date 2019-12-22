<?php

namespace App\Controller;

use App\Entity\ServicePrices;
use App\Form\ServicePricesType;
use App\Repository\ServicePricesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service-prices")
 */
class ServicePricesController extends AbstractController
{
    /**
     * @Route("/", name="service_prices_index", methods={"GET"})
     */
    public function index(ServicePricesRepository $servicePricesRepo): Response
    {
        return $this->render('service_prices/index.html.twig', [
            'service_prices' => $servicePricesRepo->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="service_prices_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $servicePrice = new ServicePrices();
        $form = $this->createForm(ServicePricesType::class, $servicePrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($servicePrice);
            $entityManager->flush();

            return $this->redirectToRoute('service_prices_index');
        }

        return $this->render('service_prices/new.html.twig', [
            'service_price' => $servicePrice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_prices_show", methods={"GET"})
     */
    public function show(ServicePrices $servicePrice): Response
    {
        return $this->render('service_prices/show.html.twig', [
            'service_price' => $servicePrice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="service_prices_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ServicePrices $servicePrice): Response
    {
        $form = $this->createForm(ServicePricesType::class, $servicePrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_prices_index');
        }

        return $this->render('service_prices/edit.html.twig', [
            'service_price' => $servicePrice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_prices_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ServicePrices $servicePrice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$servicePrice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($servicePrice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_prices_index');
    }
}
