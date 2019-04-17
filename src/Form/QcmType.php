<?php

namespace App\Form;

use App\Entity\Qcm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class QcmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', TextareaType::class, array(
                'label' => 'Question',
                'empty_data' => '',
                'attr' => array(
                    'readonly' => true,
                ),
            ))
            ->add('reponse', ChoiceType::class, array(
                'label' => 'Réponse',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    'oui' => 'oui',
                    'non' => 'non',
                    'non précisé' => 'non précisé',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Qcm::class,
        ]);
    }
}
