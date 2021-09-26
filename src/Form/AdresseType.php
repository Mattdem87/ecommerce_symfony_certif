<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez vous donnez à votre adresse'
            ])

            ->add('firstname', TextType::class, [
                'label' => 'Votre nom'
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Votre prenom'
            ])

            ->add('companie', TextType::class, [
                'label' => 'Votre entreprise',
                'required' => false,
                'attr' => [
                    'placeholder' => 'facultatif'
                ]
            ])

            ->add('adresse', TextType::class, [
                'label' => 'Votre adresse'
            ])

            ->add('codePostal', TextType::class, [
                'label' => 'Votre code postal'
            ])

            ->add('city', TextType::class, [
                'label' => 'Votre ville'
            ])

            ->add('pays', CountryType::class, [
                'label' => 'Votre pays'
            ])

            ->add('telephone', TelType::class, [
                'label' => 'Votre numéro de télephone'
            ])  

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
