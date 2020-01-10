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
 * @Route("/home/image")
 */
class HomeImageController extends AbstractController
{
    /**
     * @Route("/", name="home_image_index", methods={"GET"})
     */
    public function index(HomeImageRepository $homeImageRepository): Response
    {
        return $this->render('home_image/index.html.twig', [
            'home_images' => $homeImageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="home_image_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $homeImage = new HomeImage();
        $form = $this->createForm(HomeImageType::class, $homeImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($homeImage);
            $entityManager->flush();

            return $this->redirectToRoute('home_image_index');
        }

        return $this->render('home_image/new.html.twig', [
            'home_image' => $homeImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="home_image_show", methods={"GET"})
     */
    public function show(HomeImage $homeImage): Response
    {
        return $this->render('home_image/show.html.twig', [
            'home_image' => $homeImage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="home_image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HomeImage $homeImage): Response
    {
        $form = $this->createForm(HomeImageType::class, $homeImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home_image_index');
        }

        return $this->render('home_image/edit.html.twig', [
            'home_image' => $homeImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="home_image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, HomeImage $homeImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homeImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($homeImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home_image_index');
    }
}
