<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UtilisateurType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => "Email",
                    'attr' => ['placeholder' => 'Email']
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
                'roles',
                ChoiceType::class,
                [
                    'label' => "Rôles",
                    'choices' => [
                        'Admin' => 'ROLE_ADMIN',
                        'User' => 'ROLE_USER'
                    ],
                    'multiple' => true,
                    'attr' => ['class' => 'basic-single']
                ]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    'label' => "Nom",
                    'attr' => ['placeholder' => 'Nom'],
                    'required' => false
                ]
            )
            ->add(
                'prenom',
                TextType::class,
                [
                    'label' => "Prénom",
                    'attr' => ['placeholder' => 'Prénom'],
                    'required' => false
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                ['label' => 'S\'enregistrer']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
