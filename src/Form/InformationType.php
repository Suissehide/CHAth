<?php

namespace App\Form;

use App\Entity\Information;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_survenue', DateType::class, array(
                'label' => 'Date de survenue',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'class' => 'datepicker',
                ],
                'required' => false,
            ))

            ->add('type', PackType::class, array(
                'label' => 'Type d\'infarctus du Myocarde'
            ))
            
            ->add('traitement', ChoiceType::class, array(
                'label' => 'Activité physique',
                'placeholder' => '',
                'choices' => array(
                    'Angioplastie seule' => 'Angioplastie seule',
                    'Fibrinolyse seule' => 'Fibrinolyse seule',
                    'Fibrinolyse + Angioplastie' => 'Fibrinolyse + Angioplastie',
                    'Traitement médical' => 'Traitement médical',
                ),
                'required' => false,
            ))
            
            ->add('complications', PackType::class, array(
                'label' => 'Type d\'infarctus du Myocarde'
            ))

            ->add('CRP', NumberType::class, array(
                'label' => 'CRP ultra-sensible (mg/L)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('hemoglobine', NumberType::class, array(
                'label' => 'Hémoglobine (g/dL)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('leucocytes', NumberType::class, array(
                'label' => 'Leucocytes (G/L)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('PNN', NumberType::class, array(
                'label' => 'PNN (G/L)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('plaquettes', NumberType::class, array(
                'label' => 'Plaquettes (G/L)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('cholesterol', NumberType::class, array(
                'label' => 'Cholestérol total (g/L)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('LDL_c', NumberType::class, array(
                'label' => 'LDL-c (g/L)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('HDL_c', NumberType::class, array(
                'label' => 'HDL-c (g/L)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('HbA1c', NumberType::class, array(
                'label' => 'HbA1c (%)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
            ->add('creatininemie', NumberType::class, array(
                'label' => 'Créatininémie (%)',
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 100,
                ),
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Information::class,
        ]);
    }
}
