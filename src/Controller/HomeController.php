<?php


namespace App\Controller;

use App\Form\SpecialDayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $form = $this->createForm(SpecialDayType::class, null, ['method' => Request::METHOD_GET]);

        return $this->render("home/index.html.twig", [
            'form' => $form->createView(),
        ]);
    }
}
