<?php

namespace App\Controller;

use App\Entity\HomeImage;
use App\Entity\ContactDay;
use App\Entity\Service;
use App\Entity\ServiceSearch;
use App\Form\ContactDayType;
use App\Entity\Article;
use App\Entity\HomeInformation;
use App\Form\ServiceSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $formFilter = $this
            ->createFormBuilder()
            ->setAction($this->generateUrl("home_filter"))
            ->setMethod("GET")
            ->add("serviceName", TextType::class, ["required" => false,
                "label" => false,
                "attr" => [
                "placeholder" => "Toutes les prestations"
            ]])
            ->add("serviceLocation", TextType::class, ["required" => false,
                "label" => false,
                "attr" => [
                "placeholder" => "Toutes les villes"
            ]])
            ->getForm()
        ;

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

        /* GET IMAGES CARD POSITIONS CARD */
        $repository = $this->getDoctrine()->getRepository(HomeImage::class);
        $positions = $repository->findAll();

        /* GET THE ARTICLE WITH isHomePage = true TO SHOW ON HOME PAGE */
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->findOneBy([
            "isHomePage" => true,
        ]);

        /* GET THE INFORMATION WITH isHomePage = true TO SHOW ON HOME PAGE */
        $informationRepo = $this->getDoctrine()->getRepository(HomeInformation::class);
        $information = $informationRepo->findOneBy([
            "isHomePage" => true,
        ]);

        return $this->render("home/index.html.twig", [
            "form" => $form->createView(),
            "contactDay" => $contactDay,
            "article" => $article,
            "information" => $information ,
            "positions" => $positions,
            "formFilter" => $formFilter->createView(),
        ]);
    }

    /**
     * @Route("/search", name="home_filter")
     */
    public function search(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $repository->findServicesByQuery(
            $request->query->get("form")["serviceName"],
            $request->query->get("form")["serviceLocation"]
        );

        return $this->render("search/search.html.twig", [
            "services" => $services,
        ]);
    }
}
