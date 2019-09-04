<?php

namespace App\Form;

use App\Entity\Deces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('causePrincipale')
            ->add('codagePrincipal')
            ->add('causeSecondaire')
            ->add('codageSecondaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deces::class,
        ]);
    }
}
