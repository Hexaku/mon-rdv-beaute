<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("firstname", TextType::class, ["label" => "Prénom"])
            ->add("lastname", TextType::class, ["label" => "Nom"])
            ->add("birthdate", BirthdayType::class, ["label" => "Date de naissance"])
            ->add("phone", TextType::class, ["label" => "Téléphone"])
            ->add("adress", TextType::class, ["label" => "Adresse"])
            ->add("city", TextType::class, ["label" => "Ville"])
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                "label" => "Mot de passe",
                "type" => PasswordType::class,
                "first_options" => ["label" => "Mot de passe"],
                "second_options" => ["label" => "Confirmez le mot de passe"]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                "label" => "J'accepte les conditions générales d'utilisation",
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez accepter les conditions générales d'utilisation",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
