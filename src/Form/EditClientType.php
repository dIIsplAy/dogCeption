<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',  EmailType::class, ['required' => true])
            ->add('user', TextType::class, ['required' => true])
            ->add('adresse', TextType::class, ['required' => true])
            ->add('ville', EntityType::class, [
                'required' => true,
                'class' => Ville::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

           
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
