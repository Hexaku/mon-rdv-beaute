<?php

namespace App\Form;

use App\Entity\BusinessHour;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessHourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', ChoiceType::class, ["choices" => $this->getDays(), "label" => "Jour"])
            ->add('openTime', TimeType::class, ["label" => "Heure d'ouverture"])
            ->add('closeTime', TimeType::class, ["label" => "Heure de fermeture"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BusinessHour::class,
        ]);
    }

    public function getDays()
    {
        $choices = BusinessHour::DAYS;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
