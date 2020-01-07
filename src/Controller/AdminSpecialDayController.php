<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminSpecialDay
 * @package App\Controller
 * @Route("/admin")
 */
class AdminSpecialDayController extends AbstractController
{
    /**
     * @Route("/special/day", name="admin_special_day")
     */
    public function index(): Response
    {
        return $this->render("admin/special_day.html.twig");
    }
}
