<?php


namespace App\Controller;

use App\Entity\HomeImage;
use App\Entity\HomeInformation;
use App\Form\HomeImageType;
use App\Form\HomeInformationType;
use App\Repository\HomeImageRepository;
use App\Repository\HomeInformationRepository;
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
    public function information(HomeInformationRepository $informationRepo): Response
    {
        return $this->render('admin/home_information.html.twig', [
            'informations' => $informationRepo->findAll(),
        ]);
    }

    /**
     * @Route("/home_information/new", name="admin_home_information_new", methods={"GET","POST"})
     */
    public function informationNew(Request $request): Response
    {
        /* INITIALIZE INFORMATION REPOSITORY FOR ALL INFORMATION WITH isHomePage == true */
        $repository = $this->getDoctrine()->getRepository(HomeInformation::class);
        $informations = $repository->findBy([
            "isHomePage" => true,
        ]);

        $newInformation = new HomeInformation();
        $form = $this->createForm(HomeInformationType::class, $newInformation);
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
            'home_information' => $newInformation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/information/{id}/edit", name="admin_home_information_edit", methods={"GET","POST"})
     */
    public function informationEdit(Request $request, HomeInformation $newInformation): Response
    {
        /* INITIALIZE INFORMATION REPOSITORY FOR ALL INFORMATION WITH isHomePage == true */
        $repository = $this->getDoctrine()->getRepository(HomeInformation::class);
        $informations = $repository->findBy([
            "isHomePage" => true,
        ]);

        $form = $this->createForm(HomeInformationType::class, $newInformation);
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
            'home_information' => $newInformation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/information/{id}", name="admin_home_information_delete", methods={"DELETE"})
     */
    public function informationDelete(Request $request, HomeInformation $information): Response
    {
        if ($this->isCsrfTokenValid('delete'.$information->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($information);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_home_information');
    }

    /**
     * @Route("/image", name="admin_home_image")
     */
    public function image(HomeImageRepository $homeImageRepository): Response
    {
        return $this->render('admin/home_image.html.twig', [
            'home_images' => $homeImageRepository->findAll()
        ]);
    }

    /**
     * @Route("/image/new", name="admin_home_image_new", methods={"GET","POST"})
     */
    public function imageNew(Request $request): Response
    {
        $homeImage = new HomeImage();
        $form = $this->createForm(HomeImageType::class, $homeImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($homeImage);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home_image');
        }

        return $this->render('admin/home_image_new.html.twig', [
            'home_image' => $homeImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/{id}/edit", name="admin_home_image_edit", methods={"GET","POST"})
     */
    public function imageEdit(Request $request, HomeImage $homeImage): Response
    {
        $form = $this->createForm(HomeImageType::class, $homeImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_home_image');
        }

        return $this->render('admin/home_image_edit.html.twig', [
            'home_image' => $homeImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/{id}", name="admin_home_image_delete", methods={"DELETE"})
     */
    public function imageDelete(Request $request, HomeImage $homeImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homeImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($homeImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_home_image');
    }
}
