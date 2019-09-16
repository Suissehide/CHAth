<?php

namespace App\Form;

use App\Entity\Gene;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GeneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => ' ',
                'required' => false,
            ))
            ->add('statut', ChoiceType::class, array(
                'label' => ' ',
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'choices' => array(
                    'Muté' => 'Muté',
                    'Non muté' => 'Non muté',
                ),
                'required' => false,
            ))
            ->add('mutation', TextAreaType::class, array(
                'label' => ' ',
                'required' => false,
            ))
            ->add('frequence', NumberType::class, array(
                'label' => ' ',
                'scale' => 2,
                'attr' => array(
                    'unity' => '%',
                    'data-min' => 0,
                    'data-max' => 100,
                ),
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gene::class,
        ]);
    }
}
