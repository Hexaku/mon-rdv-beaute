<?php

namespace App\Controller;

use App\Entity\HomeImage;
use App\Form\HomeImageType;
use App\Repository\HomeImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/home")
 */
class AdminHomeImageController extends AbstractController
{
    /**
     * @Route("/image", name="admin_home_image")
     */
    public function image(HomeImageRepository $homeImageRepository): Response
    {
        $categories = ["Prestations", "Journées bien-être", "Contact"];
        return $this->render('admin/home_image.html.twig', [
            'home_images' => $homeImageRepository->findAll(),
            'categories' => $categories,
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
