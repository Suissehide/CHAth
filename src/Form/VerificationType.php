<?php

namespace App\Form;

use App\Entity\Verification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VerificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('age')
            ->add('sexe')
            ->add('date_naissance')
            ->add('taille')
            ->add('poids')
            ->add('imc')
            ->add('systolique')
            ->add('diastolique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Verification::class,
        ]);
    }
}
