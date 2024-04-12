<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom de famille'
                ]
            ])
            ->add('email', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            ->add('firstPassword', PasswordType::class, [ 
                'required' => true,
                'attr' => [
                    'placeholder' => 'Mettez votre mot de passe'
                ]
            ])
            ->add('secondPassword', PasswordType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Confirmer votre mot de passe'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
