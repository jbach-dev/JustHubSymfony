<?php

namespace App\Form;

use App\Entity\Hub;
use App\Entity\User;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Choice;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'roles',
                ChoiceType::class,
                array(
                    'attr'  =>  array(
                        'class' => 'form-control',
                        'style' => 'margin:5px 0;'
                    ),
                    'choices' =>
                    array(
                        'ROLE' => array(
                            'Rôle Sender' => 'ROLE_SENDER',
                            'Rôle Hub' => 'ROLE_HUB'
                        ),
                    ),
                    'multiple' => true,
                    'required' => true,
                )
            )

            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe'
                ],
                'second_options' => [
                    'label' => 'Répéter votre mot de passe'
                ]
            ])

            ->add('hub', EntityType::class, [
                'class' => Hub::class,
                'label' => 'Choisir mon Hub (seulement si vous avez le Rôle Hub)',
                'choice_label' => 'adress',
                'multiple' => false,
                'expanded' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
