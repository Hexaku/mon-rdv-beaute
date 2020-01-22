<?php

namespace App\Controller;

use App\Entity\UserVerify;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\VerifyTokenMailer;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        ObjectManager $manager,
        TokenGeneratorInterface $tokenGenerator,
        VerifyTokenMailer $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER']);

            $verifyUser = new UserVerify();
            $verifyUser->setUser($user);
            $verifyUser->setCreatedAt(new DateTime('now'));
            $verifyUser->setToken($tokenGenerator->generateToken());

            $data = $form->getData();
            $token = $verifyUser->getToken();

            $mailer->sendVerificationMail($data, $token);

            $manager->persist($user);
            $manager->persist($verifyUser);
            $manager->flush();

            $this->addFlash("primary", "Un email vous a été envoyé pour confirmer votre inscription");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify-email/{token}", name="app_verify", methods={"GET"})
     */
    public function verifyToken(UserVerify $userVerify, ObjectManager $manager): Response
    {
        $user = $userVerify->getUser();
        if ($user) {
            $user->setIsValidated(true);
        }

        $manager->persist($userVerify);
        $manager->flush();

        $this->addFlash("success", "Votre compte est validé ! Vous pouvez vous connecter");

        return $this->redirectToRoute('app_login');
    }
}
