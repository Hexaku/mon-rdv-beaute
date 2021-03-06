<?php

namespace App\Controller;

use App\Entity\Dashboard;
use App\Form\DashboardType;
use App\Repository\BookingRepository;
use App\Repository\DashboardRepository;
use App\Repository\ProfessionalRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServiceRepository;

/**
 * @Route("/admin")
 */
class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_index", methods={"GET","POST"})
     */
    public function index(
        Request $request,
        DashboardRepository $dashboardRepository,
        ServiceRepository $serviceRepository,
        ProfessionalRepository $professionalRepo,
        UserRepository $userRepository,
        BookingRepository $bookingRepository
    ): Response {

        /* INITIALIZE 4 VARIABLES FOR ADMIN STATS */
        $services = $serviceRepository->findAllServices();
        $professionals = $professionalRepo->findAllProfessionals();
        $members = $userRepository->findAllUsers();
        $customers = $bookingRepository->findAllBookings();

        /* CREATING OBJECTIVES ON ADMIN DASHBOARD */
        $dashboard = new Dashboard();
        $form = $this->createForm(DashboardType::class, $dashboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dashboard);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render("admin/index.html.twig", [
            "services" => $services,
            "professionals" => $professionals,
            "members" => $members,
            "customers" => $customers,
            'dashboard' => $dashboard,
            'dashboards' => $dashboardRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_dashboard_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dashboard $dashboard): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dashboard->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dashboard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
