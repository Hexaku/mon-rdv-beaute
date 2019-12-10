<?php

namespace App\Form;

use App\Entity\BusinessHour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessHourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day')
            ->add('openTime')
            ->add('closeTime')
            ->add('professional', null, ["choice_label" => "name"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BusinessHour::class,
        ]);
    }
}
