<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactProfessionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                "firstName",
                TextType::class,
                ["required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Prénom"]
            )
            ->add(
                "lastName",
                TextType::class,
                ["required" => true,
                    'constraints' => [new NotBlank()],
                "label" => "Nom"]
            )
            ->add(
                "email",
                EmailType::class,
                ["required" => true,
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ],
                "label" => "Email"]
            )
            ->add(
                "profession",
                TextType::class,
                ["required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Activité"]
            )
            ->add(
                "city",
                TextType::class,
                ["required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Lieu d'activité"]
            )
            ->add(
                "commentary",
                TextareaType::class,
                ["required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Commentaire"]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
