<?php

namespace App\Form;

use App\Entity\Participant;
use App\Form\VerificationType;
use App\Form\CardiovasculaireType;
use App\Form\InformationType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Nom',
                'required' => 'true',
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom',
                'required' => 'true',
            ))
            ->add('code', TextType::class, array(
                'label' => 'Code',
                'required' => 'true',
                'attr' => array(
                    'readonly' => true,
                ),
            ))
            ->add('numero', TextType::class, array(
                'label' => 'Numéro',
                'required' => 'true',
            ))

            // ->add('verification', EntityType::class, array(
            //     'class' => Verification::class,
            //     'choice_label' => 'date',
            // ))

            // ->add('verification', CollectionType::class, array(
            //     'entry_type' => VerificationType::class,
            //     'entry_options' => array('label' => false),
            //     'allow_add' => true,
            //     'by_reference' => false,
            // ))

            ->add('verification', VerificationType::class, array(
                'label' => 'Verification'
            ))

            ->add('cardiovasculaire', CardiovasculaireType::class, array(
                'label' => 'Cardiovasculaire'
            ))

            ->add('information', InformationType::class, array(
                'label' => 'Information'
            ))

            ->add('validation', SubmitType::class, array('label' => 'Ajouter'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
            'allow_extra_fields' => true,
        ]);
    }
}
