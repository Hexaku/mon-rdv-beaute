<?php

namespace App\Form;

use App\Entity\ServiceSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serviceName', TextType::class, [
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Toutes les prestations"
                ]
            ])
            ->add('serviceLocation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ServiceSearch::class,
            "method" => "get",
            "csrf_protection" => false,

        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
}
