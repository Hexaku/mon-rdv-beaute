<?php

namespace App\Controller;

use App\Entity\Information;
use App\Form\InformationType;
use App\Repository\HomeInformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/home")
 */
class AdminHomeInformationController extends AbstractController
{
    /**
     * @Route("/information", name="admin_home_information")
     */
    public function information(HomeInformationRepository $informationRepo): Response
    {
        return $this->render('admin/information.html.twig', [
            'informations' => $informationRepo->findAll(),
        ]);
    }

    /**
     * @Route("/home_information/new", name="admin_home_information_new", methods={"GET","POST"})
     */
    public function informationNew(Request $request): Response
    {
        /* INITIALIZE INFORMATION REPOSITORY FOR ALL INFORMATION WITH isHomePage == true */
        $repository = $this->getDoctrine()->getRepository(Information::class);
        $informations = $repository->findBy([
            "isHomePage" => true,
        ]);

        $information = new Information();
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL INFORMATIONS IsHomePage TO FALSE */
            if ($information->getIsHomePage() == true) {
                foreach ($informations as $information) {
                    $information->setIsHomePage(false);
                }
                $information->setIsHomePage(true);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($information);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home_information');
        }

        return $this->render('admin/information_new.html.twig', [
            'information' => $information,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/information/{id}/edit", name="admin_home_information_edit", methods={"GET","POST"})
     */
    public function informationEdit(Request $request, Information $information): Response
    {
        /* INITIALIZE INFORMATION REPOSITORY FOR ALL INFORMATION WITH isHomePage == true */
        $repository = $this->getDoctrine()->getRepository(Information::class);
        $informations = $repository->findBy([
            "isHomePage" => true,
        ]);

        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL INFORMATIONS IsHomePage TO FALSE */
            if ($information->getIsHomePage() == true) {
                foreach ($informations as $information) {
                    $information->setIsHomePage(false);
                }
                $information->setIsHomePage(true);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_home_information');
        }

        return $this->render('admin/information_edit.html.twig', [
            'information' => $information,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/information/{id}", name="admin_home_information_delete", methods={"DELETE"})
     */
    public function informationDelete(Request $request, Information $information): Response
    {
        if ($this->isCsrfTokenValid('delete'.$information->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($information);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_home_information');
    }
}
