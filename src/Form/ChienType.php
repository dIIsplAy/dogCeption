<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\Race;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('description', TextType::class)
            ->add(
                'isFriendly',
                CheckboxType::class,
                [
                    'label' => 'Sociable',
                    'required' => false,
                ]
            )
            ->add(
                'lof',
                CheckboxType::class,
                [
                    'label' => 'Pure race ',
                    'required' => false,
                ]
            )
            ->add('race', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Race::class,
                'multiple' => true,
                'expanded' => true,

            ])
            ->add(
                'photo',
                CollectionType::class,
                [
                    'entry_type' => PhotoType::class,
                    'entry_options' => [
                        'label' => false,
                    ],
                    'allow_add' => true,
                    'prototype_name' => '__photo__',
                    'by_reference' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chien::class,
        ]);
    }
}
