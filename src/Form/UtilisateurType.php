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
            ->add('nom', TextType::class, array(
                'label' => "Nom",
                'attr' => array(
                    'placeholder' => 'Nom'
                ),
                'required' => false,
            ))
            ->add('prenom', TextType::class, array(
                'label' => "Prénom",
                'attr' => array(
                    'placeholder' => 'Prénom'
                ),
                'required' => false,
            ))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
