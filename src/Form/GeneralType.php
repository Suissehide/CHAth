<?php

namespace App\Form;

use App\Entity\General;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GeneralType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add(
                'age',
                IntegerType::class,
                [
                    'label' => 'Âge',
                    'attr' => [
                        'unity' => '',
                        'data-min' => 0,
                        'data-max' => 120
                    ],
                    'required' => false
                ]
            )
            ->add(
                'sexe',
                ChoiceType::class,
                [
                    'label' => 'Sexe',
                    'expanded' => true,
                    'multiple' => false,
                    'placeholder' => false,
                    'choices' => [
                        'masculin' => 'masculin',
                        'féminin' => 'féminin'
                    ],
                    'required' => false
                ]
            )
            ->add(
                'dateNaissance',
                DateType::class,
                [
                    'label' => 'Date de naissance',
                    'widget' => 'single_text',
                    'format' => 'MM/yyyy',
                    'attr' => [
                        'placeholder' => 'mm/yyyy',
                        'data-min-view' => "months",
                        'data-view' => "months",
                        'data-date-format' => "mm/yyyy",
                        'class' => 'datepicker',
                        'autocomplete' => 'off'
                    ],
                    'html5' => false,
                    'required' => false
                ]
            )
            ->add(
                'taille',
                IntegerType::class,
                [
                    'label' => 'Taille',
                    'attr' => [
                        'unity' => 'cm',
                        'data-min' => '100',
                        'data-max' => '260'
                    ],
                    'required' => false
                ]
            )
            ->add(
                'poids',
                IntegerType::class,
                [
                    'label' => 'Poids',
                    'attr' => [
                        'unity' => 'kg',
                        'data-min' => 10,
                        'data-max' => 500
                    ],
                    'required' => false
                ]
            )
            ->add(
                'imc',
                NumberType::class,
                [
                    'label' => 'IMC',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'kg/m²',
                        'data-min' => 10,
                        'data-max' => 80,
                        'step' => 0.1
                    ],
                    'required' => false
                ]
            )
            ->add(
                'systolique',
                IntegerType::class,
                [
                    'label' => 'Tension artérielle systolique',
                    'attr' => [
                        'unity' => 'mmHg',
                        'data-min' => 1,
                        'data-max' => 30
                    ],
                    'required' => false
                ]
            )
            ->add(
                'diastolique',
                IntegerType::class,
                [
                    'label' => 'Tension artérielle diastolique',
                    'attr' => [
                        'unity' => 'mmHg',
                        'data-min' => 1,
                        'data-max' => 30
                    ],
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
            'data_class' => General::class,
        ]);
    }
}
