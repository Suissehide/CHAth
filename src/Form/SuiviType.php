<?php

namespace App\Form;

use App\Entity\Suivi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SuiviType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('event', ChoiceType::class, array(
                'label' => 'Évènement',
                'expanded' => false,
                'multiple' => false,
                'placeholder' => '',
                'choices' => array(
                    'SCA' => 'SCA',
                    'AVC' => 'AVC',
                    'Insuffisance cardiaque' => 'Insuffisance cardiaque',
                    'Revascularisation' => 'Revascularisation',
                    'Hospitalisation' => 'Hospitalisation',
                    'Décès' => 'Décès'
                ),
                'required' => false,
            ))

            ->add('eventDate', DateType::class, array(
                'label' => 'Date de l’événement',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'placeholder' => 'dd/mm/yyyy',
                    'class' => 'datepicker',
                    'autocomplete' => 'off'
                ],
                'required' => false,
            ))

            ->add('cause', TextareaType::class, array(
                'label' => 'Cause',
                'required' => false,
            ))

            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Suivi::class,
        ]);
    }
}
