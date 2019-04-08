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

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label' => "Email",
                'attr' => array(
                    'placeholder' => 'Email'
                ),
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'Mot de Passe',
                    'attr' => array(
                        'placeholder' => 'Mot de passe'
                    ),
                ),
                'second_options' => array(
                    'label' => 'Confirmer Mot de Passe',
                    'attr' => array(
                        'placeholder' => 'Confirmer le mot de passe'
                    ),
                ),
            ))
            ->add('roles', ChoiceType::class, array(
                'label' => "Rôles",
                'choices' => array(
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ),
                'multiple' => true,
                'attr' => array(
                    'class' => 'basic-single'
                )
            ))
            ->add('validation', SubmitType::class, array('label' => 'Créer un compte'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
