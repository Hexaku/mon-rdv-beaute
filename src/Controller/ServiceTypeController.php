<?php

namespace App\Controller;

use App\Entity\ServiceType;
use App\Form\ServiceTypeType;
use App\Repository\ServiceTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service-type")
 */
class ServiceTypeController extends AbstractController
{
    /**
     * @Route("/", name="service_type_index", methods={"GET"})
     */
    public function index(ServiceTypeRepository $serviceTypeRepo): Response
    {
        return $this->render('service_type/index.html.twig', [
            'service_types' => $serviceTypeRepo->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="service_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $serviceType = new ServiceType();
        $form = $this->createForm(ServiceTypeType::class, $serviceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serviceType);
            $entityManager->flush();

            return $this->redirectToRoute('service_type_index');
        }

        return $this->render('service_type/new.html.twig', [
            'service_type' => $serviceType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_type_show", methods={"GET"})
     */
    public function show(ServiceType $serviceType): Response
    {
        return $this->render('service_type/show.html.twig', [
            'service_type' => $serviceType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="service_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ServiceType $serviceType): Response
    {
        $form = $this->createForm(ServiceTypeType::class, $serviceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_type_index');
        }

        return $this->render('service_type/edit.html.twig', [
            'service_type' => $serviceType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ServiceType $serviceType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($serviceType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_type_index');
    }
}
