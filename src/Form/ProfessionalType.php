<?php

namespace App\Form;

use App\Entity\Professional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nom"])
            ->add('email', EmailType::class, ["label" => "Email"])
            ->add('place', TextType::class, ["label" => "Adresse"])
            ->add('description', TextType::class, ["label" => "Activité"])
            ->add('phone', TextType::class, ["label" => "Téléphone"])
            ->add('imageFile', FileType::class, ['required' => false, "label" => "Image"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professional::class,
        ]);
    }
}
