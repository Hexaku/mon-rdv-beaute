<?php

namespace App\Controller;

use App\Entity\HomeImage;
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
        $repository = $this->getDoctrine()->getRepository(HomeImage::class);
        $positions = $repository->findAll();
        dump($positions);

        return $this->render("home/index.html.twig", [
            "positions" => $positions,
        ]);
    }
}
