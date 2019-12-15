<?php

namespace App\Form;

use App\Entity\BusinessHour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessHourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', ChoiceType::class, ["choices" => $this->getChoices(), "label" => "Jour"])
            ->add('openTime', null, ["label" => "Heure d'ouverture"])
            ->add('closeTime', null, ["label" => "Heure de fermeture"])
            ->add('professional', null, ['choice_label' => 'name', "label" => "Professionnel"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BusinessHour::class,
        ]);
    }

    public function getChoices()
    {
        $choices = BusinessHour::DAYS;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
