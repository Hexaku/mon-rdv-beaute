<?php

namespace App\Controller;

use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminNewspaperController extends AbstractController
{
    /**
     * @Route("/newsletter", name="admin_newsletter", methods={"GET"})
     */
    public function newsletter(NewsletterRepository $newsletterRepo): Response
    {
        return $this->render("admin/newsletter.html.twig", [
            "newsletters" => $newsletterRepo->findAll(),
        ]);
    }
}
