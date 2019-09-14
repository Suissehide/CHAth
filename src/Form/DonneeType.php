<?php

namespace App\Form;

use App\Entity\Donnee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonneeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVisite')
            ->add('recidive')
            ->add('dateSurvenue')
            ->add('type')
            ->add('dyspnee')
            ->add('douleur')
            ->add('tabac')
            ->add('activite')
            ->add('alimentation')
            ->add('crp')
            ->add('hemoglobine')
            ->add('leucocytes')
            ->add('pnn')
            ->add('plaquettes')
            ->add('cholesterol')
            ->add('ldl')
            ->add('hdl')
            ->add('hba1c')
            ->add('hematopoiese')
            ->add('carotideCommuneDroite')
            ->add('carotideCommuneGauche')
            ->add('carotideInterneDroite')
            ->add('carotideInterneGauche')
            ->add('fraction')
            ->add('traitement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Donnee::class,
        ]);
    }
}
