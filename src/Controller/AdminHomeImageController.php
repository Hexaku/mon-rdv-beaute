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
        return $this->render('admin/home_image.html.twig', [
            'home_images' => $homeImageRepository->findAll(),
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
}
