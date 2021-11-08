<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('datePublication', DateType::class)
            ->add('titre', TextType::class)
            ->add('description', TextType::class)
            ->add('listeChien', CollectionType::class, [
                'entry_type'=> ChienType::class,
                'entry_options'=> [
                    'label' => false,
                ],
                'prototype_name' => '__chien__',
                'allow_add'=> true,
                'by_reference'=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
