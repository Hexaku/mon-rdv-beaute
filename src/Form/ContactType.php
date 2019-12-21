<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("firstName", TextType::class, [
                "required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Prénom"
            ])
            ->add("lastName", TextType::class, [
                "required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Nom"
            ])
            ->add("email", EmailType::class, [
                "required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Email"
            ])
            ->add("message", TextareaType::class, [
                "required" => true,
                'constraints' => [new NotBlank()],
                "label" => "Message"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
