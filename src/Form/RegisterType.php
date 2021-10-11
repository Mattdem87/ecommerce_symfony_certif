<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prenom',
                'attr' => [
                    'placeholder' => 'Saisissez votre prenom'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Saisissez votre nom'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
            ])

            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Saisissez votre email'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 100
                ]),
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Votre mot de passe',
                'required' => false,
                'first_options' => ['label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Saisissez un mot de passe'
                ]
            ],
                'second_options' => ['label' => 'Confirmer votre message',
                'attr' => [
                    'placeholder' => 'Confirmer votre mot de passe'
                ]]
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Veuillez accepter les CGUV',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les CGUV',
                    ]),
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => "S'inscire"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
