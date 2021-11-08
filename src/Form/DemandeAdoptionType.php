<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\DemandeAdoption;
use App\Repository\ChienRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeAdoptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $id = $options['id'];
        $builder
            ->add(
                'chien',
                EntityType::class,
                [
                    'choice_label' => 'nom',
                    'by_reference' => false,
                    'class' => Chien::class,
                    'expanded' => true,
                    'multiple' => true,
                    'query_builder' => function (ChienRepository $repository) use ($id) {
                        return $repository->demandeAdoptionChien($id);
                    },
                ],
            )
                        ->add(
                'message',
                CollectionType::class,
                [
                    'entry_type' => MessageType::class,
                    'entry_options' => [
                        'label' => false,
                    ],
                    'by_reference' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
        ->setRequired('id')
        ->setDefaults([
            'data_class' => DemandeAdoption::class,
        ]);
    }
}
