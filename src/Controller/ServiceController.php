<?php

namespace App\Controller;

use App\Entity\Professional;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="service_index", methods={"GET"})
     */
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="service_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('service_index');
        }

        return $this->render('service/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="service_show", methods={"GET"})
     */
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

    /**
     * @Route("/{slug}/booking", name="service_booking")
     */
    public function booking(Service $service): Response
    {
        /* GET PROFESSIONAL BUSINESS HOURS AND SERVICE DURATION */
        $businessHours = $service->getProfessional()->getBusinessHour()->toArray();
        $serviceDuration = $service->getDuration();

        /* DATE INTERVAL AND PERIOD BETWEEN OPEN AND CLOSE TIME */
        $result = [];
        foreach ($businessHours as $businessHour) {
            $period = new \DatePeriod(
                new \DateTime($businessHour->getOpenTime()->format("H:i")),
                new \DateInterval("PT" . $serviceDuration . "M"),
                new \DateTime($businessHour->getCloseTime()->format("H:i"))
            );

            foreach ($period as $date) {
                $date->format("H:i");
                $result[] = $date;
            }
        }

        return $this->render("service/booking.html.twig", [
            "service" => $service,
            "dates" => $result,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="service_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_index');
        }

        return $this->render('service/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_index');
    }

    /**
     * @Route("/test/{id}/{date}", name="test")
     */
    public function test(Professional $professional, DateTime $date): Response
    {
        return $this->json($professional->getName() . ' ' . $date->format('d'));
    }
}
