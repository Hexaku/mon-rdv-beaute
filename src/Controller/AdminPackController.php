<?php


namespace App\Controller;

use App\Entity\Pack;
use App\Form\PackType;
use App\Repository\PackRepository;
use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminPackController extends AbstractController
{
    /**
     * @Route("/pack", name="admin_pack", methods={"GET"})
     */
    public function pack(PackRepository $packRepository): Response
    {
        return $this->render('admin/pack.html.twig', [
            'packs' =>$packRepository->findAll(),
        ]);
    }

    /**
     * @Route("/pack/new", name="admin_pack_new", methods={"GET","POST"})
     */
    public function packNew(Request $request): Response
    {
        $pack = new Pack();
        $form = $this->createForm(PackType::class, $pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //create a slug with the name of the pack
            $slug = Slugify::generate($pack->getName());
            $pack->setSlug($slug);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pack);
            $entityManager->flush();

            return $this->redirectToRoute('admin_pack');
        }

        return $this->render('admin/pack_new.html.twig', [
            'pack' => $pack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pack/{id}/edit", name="admin_pack_edit", methods={"GET","POST"})
     */
    public function packEdit(Request $request, Pack $pack): Response
    {
        $form = $this->createForm(PackType::class, $pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_pack');
        }

        return $this->render('admin/pack_edit.html.twig', [
            'pack' => $pack,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/pack/{id}", name="admin_pack_delete", methods={"DELETE"})
     */
    public function packDelete(Request $request, Pack $pack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_pack');
    }
}
