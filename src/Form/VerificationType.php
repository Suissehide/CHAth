<?php

namespace App\Form;

use App\Entity\Verification;
use App\Form\QcmType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label' => 'Date de signature du consentement éclairé',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'placeholder' => 'dd/mm/yyyy',
                    'class' => 'datepicker',
                ],
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
