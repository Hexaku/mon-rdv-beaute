<?php

namespace App\Controller;

use App\Entity\HomeImage;
use App\Entity\ContactDay;
use App\Form\ContactDayType;
use App\Entity\Article;
use App\Entity\Information;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="home", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(HomeImage::class);
        $positions = $repository->findAll();

        /* To get contacts details of people interested by a special_day,
        send in special_day table*/
        $contactDay = new contactDay();
        $form = $this->createForm(contactDayType::class, $contactDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactDay);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        /* GET THE ARTICLE WITH isHomePage = true TO SHOW ON HOME PAGE */
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->findOneBy([
            "isHomePage" => true,
        ]);

        /* GET THE INFORMATION WITH isHomePage = true TO SHOW ON HOME PAGE */
        $informationRepo = $this->getDoctrine()->getRepository(Information::class);
        $information = $informationRepo->findOneBy([
            "isHomePage" => true,
        ]);


        return $this->render("home/index.html.twig", [
            "form" => $form->createView(),
            "contactDay" => $contactDay,
            "article" => $article,
            "home_information" => $information ,
            "positions" => $positions,

        ]);
    }
}
