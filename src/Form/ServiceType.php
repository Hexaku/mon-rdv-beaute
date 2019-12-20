<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('slogan', TextType::class)
            ->add('description', TextType::class)
            ->add('image', TextType::class)
            ->add('serviceType', EntityType::class, ["choice_label" => "type"])
            ->add('intervalTime', TimeType::class)
            ->add('duration', TimeType::class)
            ->add('area', TextType::class)
            ->add('category', EntityType::class, ["choice_label" => "name"])
            ->add('professional', EntityType::class, ["choice_label" => "name"])
            ->add('member', EntityType::class)
            ->add('price', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
