<?php

namespace App\Form;

use App\Entity\Gene;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GeneType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            // ->add('nom',
            //    TextareaType::class,
            //    array(
            //     'label' => ' ',
            //     'empty_data' => '',
            //     'attr' => array(
            //         'readonly' => true,
            //     ),
            //     'required' => false,
            // ))

            ->add(
                'statut',
                ChoiceType::class,
                [
                    'label' => ' ',
                    'expanded' => true,
                    'multiple' => false,
                    'placeholder' => false,
                    'choices' => [
                        'Muté' => 'Muté',
                        'Non muté' => 'Non muté'
                    ],
                    'required' => false
                ]
            )

            ->add(
                'mutation',
                TextareaType::class,
                [
                    'label' => ' ',
                    'required' => false
                ]
            )

            ->add(
                'frequence',
                NumberType::class,
                [
                    'label' => ' ',
                    'attr' => [
                        'unity' => '%',
                        'data-min' => 0,
                        'data-max' => 100
                    ],
                    'required' => false
                ]
            )

            ->add(
                'classification',
                ChoiceType::class,
                [
                    'label' => ' ',
                    'placeholder' => false,
                    'choices' => [
                        '' => '',
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C'
                    ],
                    'required' => false
                ]
            )

            ->add(
                'commentaire',
                TextareaType::class,
                [
                    'label' => ' ',
                    'required' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gene::class,
        ]);
    }
}
