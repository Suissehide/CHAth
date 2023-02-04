<?php

namespace App\Form;

use App\Entity\Suivi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SuiviType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder

            ->add(
                'event',
                ChoiceType::class,
                [
                    'label' => 'Évènement',
                    'expanded' => false,
                    'multiple' => false,
                    'placeholder' => '',
                    'choices' => [
                        'SCA' => 'SCA',
                        'AVC' => 'AVC',
                        'Insuffisance cardiaque' => 'Insuffisance cardiaque',
                        'Revascularisation' => 'Revascularisation',
                        'Hospitalisation' => 'Hospitalisation',
                        'Décès' => 'Décès'
                    ],
                    'required' => false
                ]
            )

            ->add(
                'eventDate',
                DateType::class,
                [
                    'label' => 'Date de l\'événement',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr' => [
                        'placeholder' => 'dd/mm/yyyy',
                        'class' => 'datepicker',
                        'autocomplete' => 'off'
                    ],
                    'html5' => false,
                    'required' => false
                ]
            )

            ->add(
                'cause',
                TextareaType::class,
                [
                    'label' => 'Cause',
                    'required' => false
                ]
            )

            ->add(
                'aucunEvenement',
                CheckboxType::class,
                [
                    'label' => '',
                    'required' => false
                ]
            )

            ->add(
                'save',
                SubmitType::class,
                ['label' => 'Sauvegarder']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Suivi::class,
        ]);
    }
}
