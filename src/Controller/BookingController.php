<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Service;
use App\Entity\User;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Service\MailerSender;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/{date}/{hour}/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(MailerSender $mailerSender, Service $service, DateTime $date, $hour): Response
    {
        /*
         * $duration is service duration minus 1 minute to show next time intervals
         * example : booking at 5PM (17h00) for 1 hour = the date interval for 6PM (18h00) will be available
         */

        $duration =($service->getDuration() * 60) - 60;
        $hourEnd = date('H:i', intval(strtotime($hour) + $duration));
        $booking = new Booking();

        $booking->setProfessional($service->getProfessional())
            ->setUser($this->getUser())
            ->setDate($date)
            ->setHour($hour)
            ->setHourEnd($hourEnd)
            ->setService($service);

        $mailerSender->recapMailClient($booking);
        $mailerSender->recapMail($booking);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();

        $this->addFlash(
            "success",
            "Votre rendez-vous est bien validé, un mail vous a été envoyé !"
        );

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}/{date}/{hour}", name="booking_recap", methods={"GET"}, options={"expose": true})
     */
    public function booking(
        Service $service,
        DateTime $date,
        Request $request,
        $hour
    ): Response {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        return $this->render('booking/recap.html.twig', [
            'service' => $service,
            'date' => $date,
            'hour' => $hour,
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }
}
