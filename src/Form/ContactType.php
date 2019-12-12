<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add("Prenom", TextType::class, ["required" => true, 'constraints' => [new NotBlank()]])
            ->add("Nom", TextType::class, ["required" => true, 'constraints' => [new NotBlank()]])
            ->add("Email", EmailType::class, ["required" => true, 'constraints' => [new NotBlank()]])
            ->add("Message", TextareaType::class, ["required" => true, 'constraints' => [new NotBlank()]])
            ->add("Envoyer", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
