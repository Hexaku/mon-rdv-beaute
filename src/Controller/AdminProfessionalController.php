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
 * Class AdminCategoryController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminProfessionalController extends AbstractController
{
    /**
     * @Route("/professional", name="admin_professional", methods={"GET"})
     */
    public function professional(ProfessionalRepository $professionalRepo): Response
    {
        return $this->render('admin/professional.html.twig', [
            'professionals' => $professionalRepo->findAll(),
        ]);
    }

    /**
     * @Route("/professional/new", name="admin_professional_new", methods={"GET","POST"})
     */
    public function professionalNew(Request $request): Response
    {
        $professional = new Professional();
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professional);
            $entityManager->flush();

            return $this->redirectToRoute('admin_professional');
        }

        return $this->render('admin/professional_new.html.twig', [
            'professional' => $professional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/professional/{id}/edit", name="admin_professional_edit", methods={"GET","POST"})
     */
    public function professionalEdit(Request $request, Professional $professional): Response
    {
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_professional');
        }

        return $this->render('admin/professional_edit.html.twig', [
            'professional' => $professional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("professional/{id}", name="admin_professional_delete", methods={"DELETE"})
     */
    public function professionalDelete(Request $request, Professional $professional): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professional->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($professional);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_professional');
    }
}
