<?php

namespace App\Controller;

use App\Entity\Dashboard;
use App\Entity\Professional;
use App\Entity\Service;
use App\Entity\User;
use App\Form\DashboardType;
use App\Repository\DashboardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_index", methods={"GET","POST"})
     */
    public function index(Request $request, DashboardRepository $dashboardRepository): Response
    {
        $repositoryService = $this->getDoctrine()->getRepository(Service::class);
        $services = $repositoryService->findAllServices();

        $repoProfessional = $this->getDoctrine()->getRepository(Professional::class);
        $professionals = $repoProfessional->findAllProfessionals();

        $repoMembers = $this->getDoctrine()->getRepository(User::class);
        $members = $repoMembers->findAllUsers();

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
