<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Information;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->findOneBy([
            "isHomePage" => true,
        ]);

        $articleProfessional = $article->getProfessional();

        $informationRepo = $this->getDoctrine()->getRepository(Information::class);
        $information = $informationRepo->findOneBy([
            "isHomePage" => true,
        ]);



        return $this->render("home/index.html.twig", [
            "article" => $article,
            "articleProfessional" => $articleProfessional,
            "information" => $information,
        ]);
    }
}
