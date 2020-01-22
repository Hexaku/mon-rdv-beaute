<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminMemberController extends AbstractController
{
    /**
     * @Route("/member", name="admin_member", methods={"GET"})
     */
    public function member(UserRepository $userRepository): Response
    {
        return $this->render("admin/member.html.twig", [
            "members" => $userRepository->findAll(),
        ]);
    }
}
