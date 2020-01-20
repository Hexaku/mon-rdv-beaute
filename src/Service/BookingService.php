<?php

namespace App\Service;

use DateInterval;
use DatePeriod;
use DateTime;
use App\Entity\Service;
use App\Repository\BookingRepository;
use App\Repository\BusinessHourRepository;

class BookingService
{
    public function bookingService(
        Service $service,
        DateTime $date,
        BusinessHourRepository $businessHourRepo,
        BookingRepository $bookingRepository
    ) {
        $reservationDays = $businessHourRepo->findBy([
            "professional" => $service->getProfessional(),
            "day" => $date->format("N"),
        ]);
        /* GET PROFESSIONAL BUSINESS HOURS AND SERVICE DURATION */
        $serviceDuration = $service->getDuration();

        /* DATE INTERVAL AND PERIOD BETWEEN OPEN AND CLOSE TIME */
        $result = [];

        /*
         * La méthode find permet de récupérer uniquement les réservations du jour sur
         * lequel nous cliquont qui sont affilié au professionel lié au service
         */
        $bookings = $bookingRepository->findBookingByProfessionalAndDate($service->getProfessional(), $date);

        foreach ($reservationDays as $reservationDay) {
            /*
             *$period va servir à afficher les heures coté js en récuperant tout les intervalles
             *de temps en fonction de la durée des services et des horraires d'ouverture du professionel.
             */
            $period = new DatePeriod(
                new DateTime($reservationDay->getOpenTime()->format("H:i")),
                new DateInterval("PT" . $serviceDuration . "M"),
                new DateTime($reservationDay->getCloseTime()->format("H:i"))
            );
            foreach ($period as $date) {
                /*
                 * Tant que $add est égale a true, l'horraire sera enregistré dans result
                 */
                $add = true;
                foreach ($bookings as $booking) {
                    /*
                     * On explode les heures de début et de fin des réservation
                     * pour les utiliser en setTime
                     */
                    $bookingHour = explode(':', $booking->getHour());
                    $bookingHourEnd = explode(':', $booking->getHourEnd());
                    $bookingDuration = $booking->getService()->getDuration();
                    $diff = 0;

                    if ($bookingDuration < $serviceDuration) {
                        $diff = $serviceDuration - $bookingDuration;
                    }

                    /*
                     * La condition empêche d'afficher les heures réservées en prenant également en compte la
                     * durée des réservations.
                     */
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
        return $result;
    }
}
