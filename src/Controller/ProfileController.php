<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\User;
use App\Form\ForgetPasswordType;
use App\Form\RegistrationFormType;
use App\Repository\BookingRepository;
use App\Repository\ServiceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile_index")
     */
    public function profile(User $user): Response
    {
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute("home");
        }
        return $this->render("profile/index.html.twig", [
            "user" => $user,
        ]);
    }

    /**
     * @Route("/profile/{id}/edit", name="profile_edit")
     */
    public function profileEdit(Request $request, ObjectManager $manager, User $user): Response
    {
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute("home");
        }

        $form = $this->createForm(RegistrationFormType::class, $user)
            ->remove("birthdate")
            ->remove("email")
            ->remove("password")
            ->remove("agreeTerms");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Vos informations ont bien été mis à jour");

            return $this->redirectToRoute('profile_index', ['id' => $user->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/{id}/password/edit", name="profile_password_edit")
     */
    public function profilePasswordEdit(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        ObjectManager $manager,
        User $user
    ): Response {
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute("home");
        }

        $form = $this->createForm(ForgetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Vous avez bien modifié votre mot de passe");

            return $this->redirectToRoute('profile_index', ['id' => $user->getId()]);
        }

        return $this->render('profile/edit_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/{id}/booking", name="profile_booking")
     */
    public function profileBookings(
        User $user,
        BookingRepository $bookingRepository
    ): Response {
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute("home");
        }

        return $this->render("profile/booking.html.twig", [
            "bookings" => $bookingRepository->findAll(),
        ]);
    }
}
