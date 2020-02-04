<?php

namespace App\Form;

use App\Entity\Professional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProfessionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nom"])
            ->add('email', EmailType::class, ["label" => "Email"])
            ->add('place', TextType::class, ["label" => "Adresse"])
            ->add('city', TextType::class, ["label" => "Ville"])
            ->add('description', TextType::class, ["label" => "Activité"])
            ->add('phone', TextType::class, ["label" => "Téléphone"])
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Image',
                'allow_delete' => false,
                'download_label' => 'voir l\'image',
            ])
            ->add('businessHour', CollectionType::class, [
                'entry_type' => BusinessHourType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professional::class,
        ]);
    }
}
