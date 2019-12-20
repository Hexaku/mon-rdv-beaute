<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminServiceController extends AbstractController
{
    /**
     * @Route("/service", name="admin_service", methods={"GET"})
     */
    public function article(ServiceRepository $serviceRepository): Response
    {
        return $this->render('admin/service.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }
}
