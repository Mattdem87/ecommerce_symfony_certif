<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prenom',
                'require' => false,
                'attr' => [
                    'placeholder' =>'Saisissez votre prenom'
                ]
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'require' => false,
                'attr' => [
                    'placeholder' =>'Saisissez votre nom'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'require' => false,
                'attr' => [
                    'placeholder' =>'Saisissez votre email'
                ]
            ])
            ->add('password', TextType::class, [
                'label' => 'Votre mot de passe',
                'require' => false,
                'attr' => [
                    'placeholder' =>'Saisissez votre mot de passe'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
