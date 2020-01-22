<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/home")
 */
class AdminHomeVideoController extends AbstractController
{
    /**
     * @Route("/video", name="admin_home_video")
     */
    public function video(VideoRepository $videoRepository): Response
    {
        return $this->render("admin/video.html.twig", [
            "videos" => $videoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/video/new", name="admin_home_video_new", methods={"GET","POST"})
     */
    public function videoNew(Request $request, VideoRepository $videoRepository): Response
    {
        /* INITIALIZE VIDEO REPOSITORY FOR ALL VIDEO WITH isHomePage == true */
        $videos = $videoRepository->findBy([
            "isHomePage" => true,
        ]);

        $newVideo = new Video();
        $form = $this->createForm(VideoType::class, $newVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL VIDEOS IsHomePage TO FALSE */
            if ($newVideo->getIsHomePage() == true) {
                foreach ($videos as $video) {
                    $video->setIsHomePage(false);
                }
                $newVideo->setIsHomePage(true);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newVideo);
            $entityManager->flush();

            return $this->redirectToRoute('admin_home_video');
        }

        return $this->render('admin/video_new.html.twig', [
            'video' => $newVideo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/video/{id}/edit", name="admin_home_video_edit", methods={"GET","POST"})
     */
    public function informationEdit(Request $request, Video $newVideo, VideoRepository $videoRepository): Response
    {
        /* INITIALIZE INFORMATION REPOSITORY FOR ALL ARTICLE WITH isHomePage == true */
        $videos = $videoRepository->findBy([
            "isHomePage" => true,
        ]);

        $form = $this->createForm(VideoType::class, $newVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL INFORMATIONS IsHomePage TO FALSE */
            if ($newVideo->getIsHomePage() == true) {
                foreach ($videos as $video) {
                    $video->setIsHomePage(false);
                }
                $newVideo->setIsHomePage(true);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_home_video');
        }

        return $this->render('admin/video_edit.html.twig', [
            'video' => $newVideo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/video/{id}", name="admin_home_video_delete", methods={"DELETE"})
     */
    public function informationDelete(Request $request, Video $video): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_home_video');
    }
}
