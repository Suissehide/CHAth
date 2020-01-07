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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('age', IntegerType::class, array(
                'label' => 'Âge',
                'attr' => array(
                    'unity' => '',
                    'data-min' => 0,
                    'data-max' => 120,
                ),
                'required' => false,
            ))
            ->add('sexe', ChoiceType::class, array(
                'label' => 'Sexe',
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'choices' => array(
                    'masculin' => 'masculin',
                    'féminin' => 'féminin',
                ),
                'required' => false,
            ))
            ->add('dateNaissance', DateType::class, array(
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'format' => 'MM/yyyy',
                'attr' => [
                    'placeholder' => 'mm/yyyy',
                    'data-min-view' => "months",
                    'data-view' => "months",
                    'data-date-format' => "mm/yyyy",
                    'class' => 'datepicker',
                ],
                'required' => false,
            ))
            ->add('taille', IntegerType::class, array(
                'label' => 'Taille',
                'attr' => array(
                    'unity' => 'cm',
                    'data-min' => '100',
                    'data-max' => '260',
                ),
                'required' => false,
            ))
            ->add('poids', IntegerType::class, array(
                'label' => 'Poids',
                'attr' => array(
                    'unity' => 'kg',
                    'data-min' => 10,
                    'data-max' => 500,
                ),
                'required' => false,
            ))
            ->add('imc', NumberType::class, array(
                'label' => 'IMC',
                'scale' => 1,
                'attr' => array(
                    'unity' => 'kg/m²',
                    'data-min' => 10,
                    'data-max' => 80,
                    'step' => 0.1,
                ),
                'required' => false,
            ))
            ->add('systolique', IntegerType::class, array(
                'label' => 'Tension artérielle systolique',
                'attr' => array(
                    'unity' => 'mmHg',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('diastolique', IntegerType::class, array(
                'label' => 'Tension artérielle diastolique',
                'attr' => array(
                    'unity' => 'mmHg',
                    'data-min' => 1,
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
            'data_class' => General::class,
        ]);
    }
}
