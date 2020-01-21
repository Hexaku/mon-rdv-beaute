<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgetPasswordType;
use App\Form\RegistrationFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{uniqid}", name="profile_index")
     */
    public function profile(User $user): Response
    {
        return $this->render("profile/index.html.twig", [
            "user" => $user,
        ]);
    }

    /**
     * @Route("/profile/{uniqid}/edit", name="profile_edit")
     */
    public function profileEdit(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user)
            ->remove("birthdate")
            ->remove("email")
            ->remove("password")
            ->remove("confirmPassword")
            ->remove("agreeTerms");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Vos informations ont bien été mis à jour");

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/{uniqid}/password/edit", name="profile_password_edit")
     */
    public function profilePasswordEdit(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        ObjectManager $manager
    ): Response {
        $user = new User();
        $form = $this->createForm(ForgetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Vous avez bien modifié votre mot de passe");

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/edit_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
