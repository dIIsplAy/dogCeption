<?php

namespace App\Form;

use App\Entity\Annonceur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAnnonceurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', TextType::class, ['required' => true])
            ->add('email', EmailType::class, [
                'required' => true,
                ])
            ->add('isSpa', ChoiceType::class,
            [
                'choices' => [
                    'oui' => true,
                    'non' => false,
                ],
                'required' => true,
                'expanded' => true, ])
            ->add('isEleveur', ChoiceType::class,
            [
                'choices' => [
                    'oui' => true,
                    'non' => false,
                ],
                'required' => true,
                'expanded' => true, ])
            ->add('nomAsso', TextType::class)
            ->add('addresse', TextType::class)
            ->add('telephone', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonceur::class,
        ]);
    }
}
