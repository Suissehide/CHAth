<?php

namespace App\Form;

use App\Entity\Cardiovasculaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CardiovasculaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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

            ->add('activite_physique', ChoiceType::class, array(
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
                'choices' => array(
                    '≥ 4 ou 5 fruits et légumes/jours' => '≥ 4 ou 5 fruits et légumes/jours',
                    '≥ 2 portions de poisson/semaine' => '≥  2 portions de poisson/semaine',
                    '≥ 3 portions de céréales ou fibres/semaine' => '≥ 3 portions de céréales ou fibres/semaine',
                    '< 15g de sel/jour' => '< 15g de sel/jour',
                    '≤ 1 boisson sucrée/semaine' => '≤ 1 boisson sucrée/semaine',
                ),
                'required' => false,
            ))

            ->add('facteurs', PackType::class, array(
                'label' => 'Facteurs de risque cardiovasculaire'
            ))
            ->add('traitement', PackType::class, array(
                'label' => 'Traitement au moment de l\'évènement'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cardiovasculaire::class,
        ]);
    }
}
