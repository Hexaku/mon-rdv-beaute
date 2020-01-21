<?php

namespace App\Controller;

use App\Entity\UserVerify;
use App\Form\ForgetPasswordEmailType;
use App\Form\ForgetPasswordType;
use App\Repository\UserRepository;
use App\Service\RecoverPasswordMailer;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ForgetPasswordController extends AbstractController
{
    /**
     * @Route("/forget-password/email/", name="recover_email")
     */
    public function getEmail(
        Request $request,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        ObjectManager $manager,
        RecoverPasswordMailer $mailer
    ): Response {
        $form = $this->createForm(ForgetPasswordEmailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data["email"];
            $emailExists = $userRepository->findOneBy(["email" => $email]);

            if ($emailExists) {
                $verifyUser = new UserVerify();

                $verifyUser->setUser($emailExists);
                $verifyUser->setCreatedAt(new DateTime('now'));
                $verifyUser->setToken($tokenGenerator->generateToken());

                $token = $verifyUser->getToken();

                $mailer->sendRecoverMail($data, $token);

                $manager->persist($verifyUser);
                $manager->flush();

                $this->addFlash(
                    "primary",
                    "Un email vient de vous être envoyé pour réinitialiser votre mot de passe"
                );

                return $this->redirectToRoute("app_login");
            }
        }

        return $this->render("recover-password/index.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/recover-password/{token}", name="recover_password")
     */
    public function recoverPassword(
        UserVerify $userVerify,
        ObjectManager $manager,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $user = $userVerify->getUser();
        $form = $this->createForm(ForgetPasswordType::class, $user);
        if ($user) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash("success", "Vous avez bien modifié votre mot de passe");

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render("recover-password/password.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
