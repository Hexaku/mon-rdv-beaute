<?php

namespace App\Form;

use App\Entity\Professional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ["label" => "Nom"])
            ->add('email', null, ["label" => "Email"])
            ->add('place', null, ["label" => "Adresse"])
            ->add('description', null, ["label" => "Activité"])
            ->add('phone', null, ["label" => "Téléphone"])
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
