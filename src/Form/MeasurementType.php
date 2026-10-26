<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperature', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Enter temperature in °C',
                ],
            ])
            ->add('humidity', NumberType::class,[
                'attr' => [
                    'placeholder' => 'Enter humidity percantege',
                ],
            ])
            ->add('precipitation', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Enter precipitation',
                ],
            ])
            ->add('wind', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Enter wind speed',
                ],
            ])
            ->add('timestamp', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Enter timestamp',
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
