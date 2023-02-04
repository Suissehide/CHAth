<?php

namespace App\Form;

use App\Entity\Deces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DecesType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add(
                'date',
                DateType::class,
                [
                    'label' => 'Date du décès',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr' => [
                        'placeholder' => 'dd/mm/yyyy',
                        'class' => 'datepicker',
                        'autocomplete' => 'off'
                    ],
                    'html5' => false,
                    'required' => false
                ]
            )

            ->add(
                'causePrincipale',
                TextType::class,
                [
                    'label' => 'Cause',
                    'required' => false
                ]
            )
            ->add(
                'codagePrincipal',
                NumberType::class,
                [
                    'label' => 'Codage prévu en MedDRA',
                    'required' => false
                ]
            )

            ->add(
                'causeSecondaire',
                TextType::class,
                [
                    'label' => 'Cause',
                    'required' => false
                ]
            )
            ->add(
                'codageSecondaire',
                NumberType::class,
                [
                    'label' => 'Codage prévu en MedDRA',
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
            'data_class' => Deces::class,
        ]);
    }
}
