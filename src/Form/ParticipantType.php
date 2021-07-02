<?php

namespace App\Form;

use App\Entity\Participant;
use App\Form\VerificationType;
use App\Form\GeneralType;
use App\Form\CardiovasculaireType;
use App\Form\InformationType;
use App\Form\SuiviType;
use App\Form\DecesType;

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
            ->add('code', TextType::class, array(
                'label' => 'Code',
                'required' => true,
                // 'attr' => array(
                //     'readonly' => true,
                // ),
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
                'label' => 'Vérification'
            ))

            ->add('general', GeneralType::class, array(
                'label' => 'Générales'
            ))

            ->add('cardiovasculaire', CardiovasculaireType::class, array(
                'label' => 'Cardiovasculaire'
            ))

            ->add('information', InformationType::class, array(
                'label' => 'Information'
            ))

            ->add('suivi', SuiviType::class, array(
                'label' => 'Suivi à un an'
            ))
            
            ->add('deces', DecesType::class, array(
                'label' => 'Décès'
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
