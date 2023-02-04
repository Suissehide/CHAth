<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PasswordFormType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add(
                'oldPassword',
                PasswordType::class,
                [
                    'mapped' => false,
                    'label' => 'Ancien mot de passe'
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de Passe',
                        'attr' => ['placeholder' => 'Mot de passe']
                    ],
                    'second_options' => [
                        'label' => 'Confirmer Mot de Passe',
                        'attr' => ['placeholder' => 'Confirmer le mot de passe']
                    ]
                ]
            )
            ->add(
                'edit',
                SubmitType::class,
                ['label' => 'Modifier le mot de passe']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
