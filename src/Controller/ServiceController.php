<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\BookingRepository;
use App\Repository\BusinessHourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        //dd($service->getProfessional()->getBookings()->toArray());
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
        BookingRepository $bookingRepository
    ): Response {
        $reservationDays = $businessHourRepo->findBy([
            "professional" => $service->getProfessional(),
            "day" => $date->format("N"),
        ]);
        /* GET PROFESSIONAL BUSINESS HOURS AND SERVICE DURATION */
        $serviceDuration = $service->getDuration();

        /* DATE INTERVAL AND PERIOD BETWEEN OPEN AND CLOSE TIME */
        $result = [];

        /*The "find" method is able to get only bookings of the day clicked linked to the professional of the service*/
        $bookings = $bookingRepository->findBookingByProfessionalAndDate($service->getProfessional(), $date);

        foreach ($reservationDays as $reservationDay) {
            /* $period is able to show hours (in JS side) while getting time intervals
             * in function of services duration and professional hours */
            $period = new DatePeriod(
                new DateTime($reservationDay->getOpenTime()->format("H:i")),
                new DateInterval("PT" . $serviceDuration . "M"),
                new DateTime($reservationDay->getCloseTime()->format("H:i"))
            );
            foreach ($period as $date) {
                /* While $add is equal to true, hour will be saved in result */
                $add = true;
                foreach ($bookings as $booking) {
                    /* We explode start and end hours of booking to use them in setTime */
                    $bookingHour = explode(':', $booking->getHour());
                    $bookingHourEnd = explode(':', $booking->getHourEnd());
                    $bookingDuration = $booking->getService()->getDuration();
                    $diff = 0;

                    if ($bookingDuration < $serviceDuration) {
                        $diff = $serviceDuration - $bookingDuration;
                    }

                    /* The condition is blocking show of hours booked, taking also the bookings duration  */
                    if ($date->format('H:i') >=
                        $booking->getDate()
                            ->setTime($bookingHour[0], intval($bookingHour[1]) - $diff)
                            ->format('H:i')
                        && $date->format('H:i') <=
                        $booking->getDate()
                            ->setTime($bookingHourEnd[0], $bookingHourEnd[1])
                            ->format('H:i')) {
                        $add = false;
                    }
                }
                if ($add) {
                    $result[] = $date->format('H:i');
                }
            }
        }

        return $this->json($result, 200, [], ["groups" => ["calendar"]]);
    }
}
