<?php

namespace App\Controller;

use App\Entity\Professional;
use App\Form\ProfessionalType;
use App\Repository\ProfessionalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/professional")
 */
class ProfessionalController extends AbstractController
{
    /**
     * @Route("/", name="professional_index", methods={"GET"})
     */
    public function index(ProfessionalRepository $professionalRepo): Response
    {
        return $this->render('professional/index.html.twig', [
            'professionals' => $professionalRepo->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="professional_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $professional = new Professional();
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professional);
            $entityManager->flush();

            return $this->redirectToRoute('professional_index');
        }

        return $this->render('professional/new.html.twig', [
            'professional' => $professional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="professional_show", methods={"GET"})
     */
    public function show(Professional $professional): Response
    {
        return $this->render('professional/show.html.twig', [
            'professional' => $professional,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="professional_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Professional $professional): Response
    {
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('professional_index');
        }

        return $this->render('professional/edit.html.twig', [
            'professional' => $professional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="professional_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Professional $professional): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professional->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($professional);
            $entityManager->flush();
        }

        return $this->redirectToRoute('professional_index');
    }
}
