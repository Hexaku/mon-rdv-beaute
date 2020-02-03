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
        DateTime $dateTime,
        BusinessHourRepository $businessHourRepo,
        BookingRepository $bookingRepository
    ) {
        $reservationDays = $businessHourRepo->findBy([
            "professional" => $service->getProfessional(),
            "day" => $dateTime->format("N"),
        ]);
        /* GET PROFESSIONAL BUSINESS HOURS AND SERVICE DURATION */
        $serviceDuration = $service->getDuration();

        /* DATE INTERVAL AND PERIOD BETWEEN OPEN AND CLOSE TIME */
        $result = [];

        /*
         * The find function takes only bookings of the day on which we click,
         * related to the professional and to the service.
         */
        $bookings = $bookingRepository->findBookingByProfessionalAndDate($service->getProfessional(), $dateTime);

        foreach ($reservationDays as $reservationDay) {
            $reservationDayOpen = $reservationDay->getOpenTime();
            $reservationDayClose = $reservationDay->getCloseTime();
            /*
             * $period is used to show hours available on the the js file
             * It uses professional business hours and the services duration
             * to create all time interval
             */
            $period = new DatePeriod(
                new DateTime($reservationDayOpen ? $reservationDayOpen->format("H:i") : "now"),
                new DateInterval("PT" . $serviceDuration . "M"),
                new DateTime($reservationDayClose ? $reservationDayClose->format("H:i") : "now")
            );
            foreach ($period as $date) {
                /*
                 * While $add is true, the hour is stocked in result
                 */
                $add = true;
                foreach ($bookings as $booking) {
                    /*
                     * We explode beginning and end hours of the bookings to use them
                     * at setTime
                     */
                    $bookingHour = explode(':', $booking->getHour());
                    $bookingHourEnd = explode(':', $booking->getHourEnd());
                    $bookingDuration = $booking->getService()->getDuration();
                    $diff = 0;

                    if ($bookingDuration < $serviceDuration) {
                        $diff = $serviceDuration - $bookingDuration;
                    }

                    /*
                     * The if condition prevent to show bookings hours and take in consideration
                     * bookings duration
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
                $now = new DateTime();
                if ($dateTime->format('Y/m/d') === $now->format('Y/m/d') && $date < $now) {
                    $add = false;
                }
                if ($add) {
                    $result[] = $date->format('H:i');
                }
            }
        }
        return $result;
    }
}
