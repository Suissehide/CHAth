<?php

namespace App\Form;

use App\Entity\Verification;
use App\Form\QcmType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class VerificationType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            // ->add('inclusion',
            //    PackType::class,
            //    array(
            //     'label' => 'Inclusion'
            // ))

            ->add(
                'inclusion',
                CollectionType::class,
                [
                    'entry_type' => QcmType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'by_reference' => false
                ]
            )

            ->add(
                'nonInclusion',
                CollectionType::class,
                [
                    'entry_type' => QcmType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'by_reference' => false
                ]
            )

            ->add(
                'date',
                DateType::class,
                [
                    'label' => 'Date de signature du consentement éclairé',
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
                'save',
                SubmitType::class,
                ['label' => 'Sauvegarder']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Verification::class,
        ]);
    }
}
