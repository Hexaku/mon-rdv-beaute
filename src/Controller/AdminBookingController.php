<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminBookingController extends AbstractController
{
    /**
     *  @Route("/admin", name="admin_booking", methods={"GET"})
     */
    public function booking(BookingRepository $bookingRepository): Response
    {
        return $this->render("admin/booking.html.twig", [
            "bookings" => $bookingRepository->findAll(),
        ]);
    }
}
