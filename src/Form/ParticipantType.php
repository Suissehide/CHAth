<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Nom',
                'required' => 'true',
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom',
                'required' => 'true',
            ))
            ->add('code', TextType::class, array(
                'label' => 'Code',
                'required' => 'true',
                'attr' => array(
                    'readonly' => true,
                ),
            ))
            ->add('numero', TextType::class, array(
                'label' => 'Numéro',
                'required' => 'true',
            ))
            ->add('validation', SubmitType::class, array('label' => 'Ajouter'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
            'allow_extra_fields' => true,
        ]);
    }
}
