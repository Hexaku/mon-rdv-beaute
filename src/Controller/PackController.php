<?php

namespace App\Controller;

use App\Entity\Pack;
use App\Form\PackType;
use App\Repository\PackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/special_day")
 */
class PackController extends AbstractController
{
    /**
     * @Route("/", name="pack_index", methods={"GET"})
     */
    public function index(PackRepository $packRepository): Response
    {
        return $this->render('special_day/index.html.twig', [
            'packs' => $packRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="pack_show", methods={"GET"})
     */
    public function show(Pack $pack): Response
    {
        return $this->render('special_day/show.html.twig', [
            'pack' => $pack,
        ]);
    }

    /**
     * @Route("/{id}", name="pack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pack $pack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pack_index');
    }
}
