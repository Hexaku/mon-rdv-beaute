<?php

namespace App\Controller;

use App\Entity\ContactDay;
use App\Entity\Newsletter;
use App\Entity\User;
use App\Form\ContactDayType;
use App\Entity\Article;
use App\Form\NewsletterType;
use App\Repository\ImageRepository;
use App\Repository\InformationRepository;
use App\Repository\ProfessionalRepository;
use App\Repository\ServiceRepository;
use App\Repository\VideoRepository;
use App\Service\FormatYoutubeLink;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     */
    public function index(
        Request $request,
        FormatYoutubeLink $formatYoutubeLink,
        ImageRepository $imageRepository,
        InformationRepository $informationRepo,
        VideoRepository $videoRepository
    ): Response {
        /* CREATING FILTER FORM */
        $formFilter = $this
            ->createFormBuilder()
            ->setAction($this->generateUrl("home_filter"))
            ->setMethod("GET")
            ->add("serviceName", TextType::class, ["required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Toutes les prestations",
                    "id" => "filter-service-name",
            ]])
            ->add("serviceLocation", TextType::class, ["required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Toutes les villes",
                    "id" => "filter-service-location",
            ]])
            ->getForm()
        ;

        /* GET IMAGES CARD POSITIONS CARD */
        $positions = $imageRepository->findAll();

        /* GET THE INFORMATION WITH isHomePage = true TO SHOW ON HOME PAGE */
        $information = $informationRepo->findOneBy([
            "isHomePage" => true,
        ]);

        /* GET THE VIDEO WITH isHomePage = true TO SHOW ON HOME PAGE */
        $video = $videoRepository->findOneBy([
            "isHomePage" => true,
        ]);

        if ($video !== null) {
            /* FORMAT YOUTUBE LINK TO FIT IFRAME YT PATTERN */
            $video->setLink($formatYoutubeLink->format($video->getLink()));
        }

        /* GET THE ARTICLE WITH isHomePage = true TO SHOW ON HOME PAGE */
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->findOneBy([
            "isHomePage" => true,
        ]);

        /* CREATE NEWSLETTER FORM AND ADD DATA IN DATABASE */
        $newsletter = new Newsletter();
        $formNewsletter = $this->createForm(NewsletterType::class, $newsletter);
        $formNewsletter->handleRequest($request);

        if ($formNewsletter->isSubmitted() && $formNewsletter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render("home/index.html.twig", [
            "article" => $article,
            "information" => $information,
            "video" => $video,
            "positions" => $positions,
            "formFilter" => $formFilter->createView(),
            "formNewsletter" => $formNewsletter->createView(),
        ]);
    }

    /**
     * @Route("/search", name="home_filter")
     */
    public function search(Request $request, ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findServicesByQuery(
            $request->query->get("form")["serviceName"],
            $request->query->get("form")["serviceLocation"]
        );

        return $this->render("search/search.html.twig", [
            "services" => $services,
        ]);
    }

    /**
     * @Route("/api/filter/services", name="home_filter_fetch_services")
     */
    public function fetchServices(ServiceRepository $serviceRepository, Request $request): Response
    {
        $services = $serviceRepository->findAllMatching($request->query->get('query'));

        return $this->json($services, 200, [], [
            "groups" => ["filter"]
        ]);
    }

    /**
     * @Route("/api/filter/professionals", name="home_filter_fetch_professionals")
     */
    public function fetchProfessionals(ProfessionalRepository $professionalRepo, Request $request): Response
    {
        $professionals = $professionalRepo->findAllMatching($request->query->get('query'));

        return $this->json($professionals, 200, [], [
            "groups" => ["filter"]
        ]);
    }
}
