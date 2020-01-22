<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\BookingRepository;
use App\Repository\BusinessHourRepository;
use App\Repository\ServiceRepository;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateInterval;
use DatePeriod;
use DateTime;

/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
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
        return $this->render("service/booking.html.twig", [
            "service" => $service,
        ]);
    }

    /**
     * @Route("/{id}/{date}", name="test")
     */
    public function fetch(
        Service $service,
        DateTime $date,
        BusinessHourRepository $businessHourRepo,
        BookingRepository $bookingRepository,
        BookingService $bookingService
    ): Response {

        $result = $bookingService->bookingService($service, $date, $businessHourRepo, $bookingRepository);

        return $this->json($result, 200, [], ["groups" => ["calendar"]]);
    }
}
