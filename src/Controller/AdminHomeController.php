<?php


namespace App\Controller;

use App\Entity\Information;
use App\Form\InformationType;
use App\Repository\InformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/home")
 */
class AdminHomeController extends AbstractController
{
    /**
     * @Route("/information", name="admin_home_information")
     */
    public function information(InformationRepository $informationRepo): Response
    {
        return $this->render('admin/home_information.html.twig', [
            'informations' => $informationRepo->findAll(),
        ]);
    }

    /**
     * @Route("/information/new", name="admin_home_information_new", methods={"GET","POST"})
     */
    public function informationNew(Request $request): Response
    {
        /* INITIALIZE INFORMATION REPOSITORY FOR ALL ARTICLE WITH isHomePage == true */
        $repository = $this->getDoctrine()->getRepository(Information::class);
        $informations = $repository->findBy([
            "isHomePage" => true,
        ]);

        $newInformation = new Information();
        $form = $this->createForm(InformationType::class, $newInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL INFORMATIONS IsHomePage TO FALSE */
            if ($newInformation->getIsHomePage() == true) {
                foreach ($informations as $information) {
                    $information->setIsHomePage(false);
                }
                $newInformation->setIsHomePage(true);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newInformation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home_information');
        }

        return $this->render('admin/home_information_new.html.twig', [
            'information' => $newInformation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/information/{id}/edit", name="admin_home_information_edit", methods={"GET","POST"})
     */
    public function informationEdit(Request $request, Information $newInformation): Response
    {
        /* INITIALIZE INFORMATION REPOSITORY FOR ALL ARTICLE WITH isHomePage == true */
        $repository = $this->getDoctrine()->getRepository(Information::class);
        $informations = $repository->findBy([
            "isHomePage" => true,
        ]);

        $form = $this->createForm(InformationType::class, $newInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL INFORMATIONS IsHomePage TO FALSE */
            if ($newInformation->getIsHomePage() == true) {
                foreach ($informations as $information) {
                    $information->setIsHomePage(false);
                }
                $newInformation->setIsHomePage(true);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_home_information');
        }

        return $this->render('admin/home_information_edit.html.twig', [
            'information' => $newInformation,
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
