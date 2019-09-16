<?php

namespace App\Form;

use App\Entity\Donnee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DonneeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVisite', DateType::class, array(
                'label' => 'Date de la visite de suivi',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'placeholder' => 'dd/mm/yyyy',
                    'class' => 'datepicker',
                ],
                'required' => false,
            ))
            ->add('recidive', ChoiceType::class, array(
                'label' => 'Récidive d’événement cardiovasculaire',
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                    'Non précisé' => 'Non précisé',
                ),
                'required' => false,
            ))
            ->add('dateSurvenue', DateType::class, array(
                'label' => 'Date de survenue',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'placeholder' => 'dd/mm/yyyy',
                    'class' => 'datepicker',
                ],
                'required' => false,
            ))
            ->add('type', ChoiceType::class, array(
                'label' => 'Activité physique',
                'placeholder' => '',
                'choices' => array(
                    'Infarctus du myocarde' => 'Infarctus du myocarde',
                    'AVC ischémique d’origine athéromateuse' => 'AVC ischémique d’origine athéromateuse',
                    'Revascularisation coronarienne' => 'Revascularisation coronarienne',
                    'Autre' => 'Autre',
                ),
                'required' => false,
            ))
            ->add('dyspnee', NumberType::class, array(
                'label' => 'Dyspnée',
                'scale' => 2,
                'attr' => array(
                    'unity' => 'NYHA',
                    'data-min' => 0,
                    'data-max' => 0,
                ),
                'required' => false,
            ))
            ->add('douleur', NumberType::class, array(
                'label' => 'Douleur thoracique',
                'scale' => 2,
                'attr' => array(
                    'unity' => 'CCS',
                    'data-min' => 0,
                    'data-max' => 0,
                ),
                'required' => false,
            ))
            ->add('tabac', ChoiceType::class, array(
                'label' => 'Tabac',
                'placeholder' => '',
                'choices' => array(
                    'Jamais fumé ou arrêté > 12 mois' => 'Jamais fumé ou arrêté > 12 mois',
                    'Arrêt depuis moins de 12 mois' => 'Arrêt depuis moins de 12 mois',
                    'Fumeur actuel' => 'Fumeur actuel',
                ),
                'required' => false,
            ))
            ->add('activite', ChoiceType::class, array(
                'label' => 'Activité physique',
                'placeholder' => '',
                'choices' => array(
                    '> 150 min/semaine d’activité modérée ou > 75 min/semaine d’activité vigoureuse' => '> 150 min/semaine d’activité modérée ou > 75 min/semaine d’activité vigoureuse',
                    '1 à 150 min/semaine d’activité modérée ou 1 à 75 min/semaine d’activité vigoureuse' => '1 à 150 min/semaine d’activité modérée ou 1 à 75 min/semaine d’activité vigoureuse',
                    'Aucune' => 'Aucune',
                ),
                'required' => false,
            ))
            ->add('alimentation', ChoiceType::class, array(
                'label' => 'Alimentation',
                'placeholder' => '',
                'multiple' => true,
                'expanded' => true,
                'choices' => array(
                    '≥ 4 ou 5 fruits et légumes / jours' => '≥ 4 ou 5 fruits et légumes / jours',
                    '≥ 2 portions de poisson / semaine' => '≥ 2 portions de poisson / semaine',
                    '≥ 3 portions de céréales ou fibres / semaine' => '≥ 3 portions de céréales ou fibres / semaine',
                    '< 15g de sel / jour' => '< 15g de sel / jour',
                    '≤ 1 boisson sucrée / semaine' => '≤ 1 boisson sucrée / semaine',
                ),
                'required' => false,
            ))

            ->add('facteurs', PackType::class, array(
                'label' => 'Facteurs de risque cardiovasculaire'
            ))

            ->add('traitement', PackType::class, array(
                'label' => 'Traitement mis en place suite à l\'événement cardiovasculaire'
            ))

            ->add('crp', NumberType::class, array(
                'label' => 'CRP ultra-sensible',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'mg/L',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('hemoglobine', NumberType::class, array(
                'label' => 'Hémoglobine',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'g/dL',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('leucocytes', NumberType::class, array(
                'label' => 'Leucocytes',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'G/L',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('pnn', NumberType::class, array(
                'label' => 'PNN',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'G/L',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('plaquettes', NumberType::class, array(
                'label' => 'Plaquettes',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'G/L',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('cholesterol', NumberType::class, array(
                'label' => 'Cholestérol total',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'g/L',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('ldl', NumberType::class, array(
                'label' => 'LDL-c',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'g/L',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('hdl', NumberType::class, array(
                'label' => 'HDL-c',
                'scale' => 0,
                'attr' => array(
                    'unity' => 'g/L',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('hba1c', NumberType::class, array(
                'label' => ' ',
                'scale' => 0,
                'attr' => array(
                    'unity' => '%',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('hematopoiese', ChoiceType::class, array(
                'label' => 'Mise en évidence d’une mutation',
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                    'Non précisé' => 'Non précisé',
                ),
                'required' => false,
            ))
            ->add('genes', PackType::class, array(
                'label' => 'Gènes'
            ))


            ->add('carotideCommuneDroite', NumberType::class, array(
                'label' => 'Volume athérome carotide commune droite',
                'attr' => array(
                    'unity' => '',
                    'data-min' => 0,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('carotideCommuneGauche', NumberType::class, array(
                'label' => 'Volume athérome carotide commune gauche',
                'attr' => array(
                    'unity' => '',
                    'data-min' => 0,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('carotideInterneDroite', NumberType::class, array(
                'label' => 'Volume athérome carotide interne droite',
                'attr' => array(
                    'unity' => '',
                    'data-min' => 0,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('carotideInterneGauche', NumberType::class, array(
                'label' => 'Volume athérome carotide interne gauche',
                'attr' => array(
                    'unity' => '',
                    'data-min' => 0,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('fraction', NumberType::class, array(
                'label' => 'Fraction d’éjection ventriculaire gauche',
                'attr' => array(
                    'unity' => '%',
                    'data-min' => 0,
                    'data-max' => 30,
                ),
                'required' => false,
            ))


            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Donnee::class,
        ]);
    }
}
