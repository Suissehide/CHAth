<?php

namespace App\Form;

use App\Entity\Verification;
use App\Form\QcmType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class VerificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('inclusion', CollectionType::class, array(
            //     'entry_type' => QcmType::class,
            //     'entry_options' => array('label' => false),
            //     'allow_add' => true,
            //     'by_reference' => false,
            // ))

            ->add('inclusion', PackType::class, array(
                'label' => 'Inclusion'
            ))

            ->add('non_inclusion', PackType::class, array(
                'label' => 'Non inclusion'
            ))

            ->add('date', DateType::class, array(
                'label' => 'Date',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
            ))
            ->add('age', IntegerType::class, array(
                'label' => 'Âge',
                'attr' => array(
                    'min' => 0,
                    'max' => 120,
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
            ->add('date_naissance', DateType::class, array(
                'label' => 'Date de naissance (mm/aaaa)',
                'widget' => 'single_text',
                'format' => 'MM/yyyy',
                'required' => false,
            ))
            ->add('taille', IntegerType::class, array(
                'label' => 'Taille (cm)',
                'attr' => array(
                    'min' => 100,
                    'max' => 260,
                ),
                'required' => false,
            ))
            ->add('poids', IntegerType::class, array(
                'label' => 'Poids (kg)',
                'attr' => array(
                    'min' => 10,
                    'max' => 500,
                ),
                
            ))
            ->add('imc', NumberType::class, array(
                'label' => 'IMC (kg/m²)',
                'scale' => 2,
                'attr' => array(
                    'min' => 10,
                    'max' => 80,
                ),
                'required' => false,
            ))
            ->add('systolique', NumberType::class, array(
                'label' => 'Tension artérielle systolique (mmHg)',
                'scale' => 2,
                'attr' => array(
                    'min' => 1,
                    'max' => 30,
                ),
                'required' => false,
            ))
            ->add('diastolique', NumberType::class, array(
                'label' => 'Tension artérielle diastolique (mmHg)',
                'scale' => 2,
                'attr' => array(
                    'min' => 1,
                    'max' => 30,
                ),
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Verification::class,
        ]);
    }
}
