<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/* form uses in pop-up window in special day (journées bien-être)*/
class ContactDayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class, [
                "label" => "Nom",
                "required" => true,
                "constraints" => [new NotBlank()]
            ])
            ->add('Email', EmailType::class, [
                "label" => "Email",
                "required" => true,
                "constraints" => [new NotBlank()]
            ])
            ->add('Phone', TextType::class, [
                "label" => "Téléphone (facultatif)",
                "required" => false,
                ])
            ->add('Comment', TextareaType::class, [
                "label" => "Message (facultatif)",
                "required" => false,
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
