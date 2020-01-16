<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
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
        return $this->render('admin/image.html.twig', [
            'images' => $homeImageRepository->findAll()
        ]);
    }

    /**
     * @Route("/image/new", name="admin_home_image_new", methods={"GET","POST"})
     */
    public function imageNew(Request $request): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home_image');
        }

        return $this->render('admin/image_new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/{id}/edit", name="admin_home_image_edit", methods={"GET","POST"})
     */
    public function imageEdit(Request $request, Image $image): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_home_image');
        }

        return $this->render('admin/image_edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/{id}", name="admin_home_image_delete", methods={"DELETE"})
     */
    public function imageDelete(Request $request, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_home_image');
    }
}
