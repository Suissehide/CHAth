<?php

namespace App\Form;

use App\Entity\Donnee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonneeType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add(
                'dateVisite',
                DateType::class,
                [
                    'label' => 'Date de la visite de suivi',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr' => [
                        'placeholder' => 'dd/mm/yyyy',
                        'class' => 'datepicker',
                        'autocomplete' => 'off',
                    ],
                    'html5' => false,
                    'required' => false
                ]
            )
            ->add(
                'recidive',
                ChoiceType::class,
                [
                    'label' => 'Récidive d\'événement cardiovasculaire',
                    'expanded' => true,
                    'multiple' => false,
                    'placeholder' => false,
                    'choices' => [
                        'Oui' => 'Oui',
                        'Non' => 'Non',
                        'Non précisé' => 'Non précisé'
                    ],
                    'required' => false
                ]
            )
            ->add(
                'dateSurvenue',
                DateType::class,
                [
                    'label' => 'Date de survenue',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr' => [
                        'placeholder' => 'dd/mm/yyyy',
                        'class' => 'datepicker',
                        'autocomplete' => 'off',
                    ],
                    'html5' => false,
                    'required' => false
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    'label' => 'Type d\'événement',
                    'placeholder' => '',
                    'choices' => [
                        'Infarctus du myocarde' => 'Infarctus du myocarde',
                        'AVC ischémique d\'origine athéromateuse' => 'AVC ischémique d\'origine athéromateuse',
                        'Revascularisation coronarienne' => 'Revascularisation coronarienne',
                        'Autre' => 'Autre'
                    ],
                    'required' => false
                ]
            )
            ->add(
                'dyspnee',
                IntegerType::class,
                [
                    'label' => 'Dyspnée',
                    'attr' => [
                        'unity' => 'NYHA',
                        'data-min' => 0,
                        'data-max' => 0
                    ],
                    'required' => false
                ]
            )
            ->add(
                'douleur',
                IntegerType::class,
                [
                    'label' => 'Douleur thoracique',
                    'attr' => [
                        'unity' => 'CCS',
                        'data-min' => 0,
                        'data-max' => 0
                    ],
                    'required' => false
                ]
            )
            ->add(
                'tabac',
                ChoiceType::class,
                [
                    'label' => 'Tabac',
                    'placeholder' => '',
                    'choices' => [
                        'Jamais fumé ou arrêté > 12 mois' => 'Jamais fumé ou arrêté > 12 mois',
                        'Arrêt depuis moins de 12 mois' => 'Arrêt depuis moins de 12 mois',
                        'Fumeur actuel' => 'Fumeur actuel'
                    ],
                    'required' => false
                ]
            )
            ->add(
                'activite',
                ChoiceType::class,
                [
                    'label' => 'Activité physique',
                    'placeholder' => '',
                    'choices' => [
                        '> 150 min/semaine d\'activité modérée ou > 75 min/semaine d\'activité vigoureuse' => '> 150 min/semaine d\'activité modérée ou > 75 min/semaine d\'activité vigoureuse',
                        '1 à 150 min/semaine d\'activité modérée ou 1 à 75 min/semaine d\'activité vigoureuse' => '1 à 150 min/semaine d\'activité modérée ou 1 à 75 min/semaine d\'activité vigoureuse',
                        'Aucune' => 'Aucune'
                    ],
                    'required' => false
                ]
            )
            ->add(
                'alimentation',
                ChoiceType::class,
                [
                    'label' => 'Alimentation',
                    'placeholder' => '',
                    'multiple' => true,
                    'expanded' => true,
                    'choices' => [
                        '≥ 4 ou 5 fruits et légumes/jours' => '≥ 4 ou 5 fruits et légumes/jours',
                        '≥ 2 portions de poisson/semaine' => '≥  2 portions de poisson/semaine',
                        '≥ 3 portions de céréales ou fibres/semaine' => '≥ 3 portions de céréales ou fibres/semaine',
                        '< 15g de sel/jour' => '< 15g de sel/jour',
                        '≤ 1 boisson sucrée/semaine' => '≤ 1 boisson sucrée/semaine'
                    ],
                    'required' => false
                ]
            )

            ->add(
                'facteurs',
                CollectionType::class,
                [
                    'entry_type' => QcmType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'by_reference' => false
                ]
            )

            ->add(
                'traitement',
                CollectionType::class,
                [
                    'entry_type' => QcmType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'by_reference' => false
                ]
            )

            ->add(
                'crp',
                NumberType::class,
                [
                    'label' => 'CRP ultra-sensible',
                    'attr' => [
                        'unity' => 'mg/L',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'hemoglobine',
                NumberType::class,
                [
                    'label' => 'Hémoglobine',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'g/dL',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.1
                    ],
                    'required' => false
                ]
            )
            ->add(
                'leucocytes',
                NumberType::class,
                [
                    'label' => 'Leucocytes',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'G/L',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'pnn',
                NumberType::class,
                [
                    'label' => 'PNN',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'G/L',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )

            ->add(
                'IL1B',
                NumberType::class,
                [
                    'label' => 'IL-1β',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'pg/mL',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'IL6',
                NumberType::class,
                [
                    'label' => 'IL6',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'pg/mL',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'IL10',
                NumberType::class,
                [
                    'label' => 'IL10',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'pg/mL',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'IL18',
                NumberType::class,
                [
                    'label' => 'IL18',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'pg/mL',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'TNFa',
                NumberType::class,
                [
                    'label' => 'TNF-α',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'pg/mL',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )

            ->add(
                'plaquettes',
                NumberType::class,
                [
                    'label' => 'Plaquettes',
                    'scale' => 1,
                    'attr' => [
                        'unity' => 'G/L',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.1
                    ],
                    'required' => false
                ]
            )
            ->add(
                'cholesterol',
                NumberType::class,
                [
                    'label' => 'Cholestérol total',
                    'scale' => 2,
                    'attr' => [
                        'unity' => 'g/L',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'ldl',
                NumberType::class,
                [
                    'label' => 'LDL-c',
                    'scale' => 2,
                    'attr' => [
                        'unity' => 'g/L',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'hdl',
                NumberType::class,
                [
                    'label' => 'HDL-c',
                    'scale' => 2,
                    'attr' => [
                        'unity' => 'g/L',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.01
                    ],
                    'required' => false
                ]
            )
            ->add(
                'hba1c',
                NumberType::class,
                [
                    'label' => ' ',
                    'scale' => 1,
                    'attr' => [
                        'unity' => '%',
                        'data-min' => 0,
                        'data-max' => 100,
                        'step' => 0.1
                    ],
                    'required' => false
                ]
            )
            ->add(
                'creatininemie',
                IntegerType::class,
                [
                    'label' => ' ',
                    'attr' => [
                        'unity' => 'µmol/L',
                        'data-min' => 0,
                        'data-max' => 100
                    ],
                    'required' => false
                ]
            )

            ->add(
                'hematopoiese',
                ChoiceType::class,
                [
                    'label' => 'Mise en évidence d\'une mutation',
                    'expanded' => true,
                    'multiple' => false,
                    'placeholder' => false,
                    'choices' => [
                        'Oui' => 'Oui',
                        'Non' => 'Non',
                        'Non précisé' => 'Non précisé'
                    ],
                    'required' => false
                ]
            )

            ->add(
                'numberOfMutation',
                IntegerType::class,
                [
                    'label' => 'Nombre de mutation',
                    'required' => false
                ]
            )

            ->add(
                'genes',
                CollectionType::class,
                [
                    'entry_type' => GeneType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'by_reference' => false
                ]
            )

            ->add(
                'carotideCommuneDroite',
                IntegerType::class,
                [
                    'label' => 'Volume athérome carotide commune droite',
                    'attr' => [
                        'unity' => '',
                        'data-min' => 0,
                        'data-max' => 100
                    ],
                    'required' => false
                ]
            )
            ->add(
                'carotideCommuneDroiteDone',
                CheckboxType::class,
                [
                    'label' => '',
                    'required' => false
                ]
            )

            ->add(
                'carotideCommuneGauche',
                IntegerType::class,
                [
                    'label' => 'Volume athérome carotide commune gauche',
                    'attr' => [
                        'unity' => '',
                        'data-min' => 0,
                        'data-max' => 100
                    ],
                    'required' => false
                ]
            )
            ->add(
                'carotideCommuneGaucheDone',
                CheckboxType::class,
                [
                    'label' => '',
                    'required' => false
                ]
            )

            ->add(
                'carotideInterneDroite',
                IntegerType::class,
                [
                    'label' => 'Volume athérome carotide interne droite',
                    'attr' => [
                        'unity' => '',
                        'data-min' => 0,
                        'data-max' => 100
                    ],
                    'required' => false
                ]
            )
            ->add(
                'carotideInterneDroiteDone',
                CheckboxType::class,
                [
                    'label' => '',
                    'required' => false
                ]
            )

            ->add(
                'carotideInterneGauche',
                IntegerType::class,
                [
                    'label' => 'Volume athérome carotide interne gauche',
                    'attr' => [
                        'unity' => '',
                        'data-min' => 0,
                        'data-max' => 100
                    ],
                    'required' => false
                ]
            )
            ->add(
                'carotideInterneGaucheDone',
                CheckboxType::class,
                [
                    'label' => '',
                    'required' => false
                ]
            )

            ->add(
                'fraction',
                IntegerType::class,
                [
                    'label' => 'Fraction d\'éjection ventriculaire gauche',
                    'attr' => [
                        'unity' => '%',
                        'data-min' => 0,
                        'data-max' => 100
                    ],
                    'required' => false
                ]
            )
            ->add(
                'fractionDone',
                CheckboxType::class,
                [
                    'label' => '',
                    'required' => false
                ]
            )

            ->add(
                'stenoses',
                ChoiceType::class,
                [
                    'label' => 'Sténoses carotidiennes > 50%',
                    'expanded' => true,
                    'multiple' => false,
                    'placeholder' => false,
                    'choices' => [
                        'Oui' => 'Oui',
                        'Non' => 'Non',
                        'Non précisé' => 'Non précisé'
                    ],
                    'required' => false
                ]
            )
            ->add(
                'ips',
                ChoiceType::class,
                [
                    'label' => 'IPS < 0.9',
                    'expanded' => true,
                    'multiple' => false,
                    'placeholder' => false,
                    'choices' => [
                        'Oui' => 'Oui',
                        'Non' => 'Non',
                        'Non précisé' => 'Non précisé'
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
            'data_class' => Donnee::class,
        ]);
    }
}
