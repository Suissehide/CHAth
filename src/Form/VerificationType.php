<?php

namespace App\Form;

use App\Entity\Verification;
use App\Form\QcmType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
                'attr' => [
                    'placeholder' => 'dd/mm/yyyy',
                    'class' => 'datepicker',
                ],
                'required' => false,
            ))
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
            ->add('date_naissance', DateType::class, array(
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'format' => 'MM/yyyy',
                'attr' => [
                    'placeholder' => 'dd/mm/yyyy',
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
                'scale' => 2,
                'attr' => array(
                    'unity' => 'kg/m²',
                    'data-min' => 10,
                    'data-max' => 80,
                ),
                'required' => false,
            ))
            ->add('systolique', NumberType::class, array(
                'label' => 'Tension artérielle systolique',
                'scale' => 2,
                'attr' => array(
                    'unity' => 'mmHg',
                    'data-min' => 1,
                    'data-max' => 30,
                ),
                'required' => false,
            ))
            ->add('diastolique', NumberType::class, array(
                'label' => 'Tension artérielle diastolique',
                'scale' => 2,
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
            'data_class' => Verification::class,
        ]);
    }
}
