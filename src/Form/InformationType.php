<?php

namespace App\Form;

use App\Entity\Information;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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

            ->add('type', PackType::class, array(
                'label' => 'Type d\'infarctus du Myocarde'
            ))
            
            ->add('traitementPhaseAigue', ChoiceType::class, array(
                'label' => 'Alimentation',
                'placeholder' => '',
                'multiple' => true,
                'expanded' => true,
                'choices' => array(
                    'Angioplastie' => 'Angioplastie',
                    'Fibrinolyse' => 'Fibrinolyse',
                    'Pontage' => 'Pontage',
                    'Traitement médical' => 'Traitement médical',
                ),
                'required' => false,
            ))
            
            ->add('complications', PackType::class, array(
                'label' => 'Type d\'infarctus du Myocarde'
            ))

            ->add('crp', NumberType::class, array(
                'label' => 'CRP ultra-sensible',
                'attr' => array(
                    'unity' => 'mg/L',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.01,
                ),
                'required' => false,
            ))
            ->add('hemoglobine', NumberType::class, array(
                'label' => 'Hémoglobine',
                'scale' => 1,
                'attr' => array(
                    'unity' => 'g/dL',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.1,
                ),
                'required' => false,
            ))
            ->add('leucocytes', NumberType::class, array(
                'label' => 'Leucocytes',
                'scale' => 1,
                'attr' => array(
                    'unity' => 'G/L',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.1,
                ),
                'required' => false,
            ))
            ->add('PNN', NumberType::class, array(
                'label' => 'PNN',
                'scale' => 1,
                'attr' => array(
                    'unity' => 'G/L',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.1,
                ),
                'required' => false,
            ))
            ->add('plaquettes', NumberType::class, array(
                'label' => 'Plaquettes',
                'scale' => 1,
                'attr' => array(
                    'unity' => 'G/L',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.1,
                ),
                'required' => false,
            ))
            ->add('cholesterol', NumberType::class, array(
                'label' => 'Cholestérol total',
                'scale' => 2,
                'attr' => array(
                    'unity' => 'g/L',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.01,
                ),
                'required' => false,
            ))
            ->add('LDLC', NumberType::class, array(
                'label' => 'LDL-c',
                'scale' => 2,
                'attr' => array(
                    'unity' => 'g/L',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.01,
                ),
                'required' => false,
            ))
            ->add('HDLC', NumberType::class, array(
                'label' => 'HDL-c',
                'scale' => 2,
                'attr' => array(
                    'unity' => 'g/L',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.01,
                ),
                'required' => false,
            ))
            ->add('HbA1c', NumberType::class, array(
                'label' => 'HbA1c',
                'scale' => 1,
                'attr' => array(
                    'unity' => '%',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.1,
                ),
                'required' => false,
            ))
            ->add('creatininemie', NumberType::class, array(
                'label' => 'Créatininémie',
                'scale' => 1,
                'attr' => array(
                    'unity' => '%',
                    'data-min' => 0,
                    'data-max' => 100,
                    'step' => 0.1,
                ),
                'required' => false,
            ))

            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Information::class,
        ]);
    }
}
