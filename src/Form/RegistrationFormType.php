<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'input-Civ Insc--firstName',
                    'placeholder' => 'Prénom'
                ],
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }}'
                        ])
                    ],
                'label' => false
            ])

            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'input-Civ Insc--lastName',
                    'placeholder' => 'Nom'
                ],
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }}'
                    ])
                ],
                'label' => false
            ])

            ->add('pseudo', TextType::class,[
                'attr' => [
                    'class' => 'insc--pseudo',
                    'placeholder' => 'Pseudo'
                ],
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'le pseudo doit contenir au moins {{ limit }}'
                    ])
                ],
                'label' => false
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input-formatV2 Insc--email',
                    'placeholder' => 'Email'
                ],
                'trim' => true,
                'label' => false
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'Accord'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez remplir le email',
                    ])
                ],
            ])

            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'first_options' => [
                    'label' =>  false,
                    'attr' => [
                      'placeholder' =>'Saisissez votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' =>[
                        'placeholder' => 'Confirmez votre mot de passe',

                    ]
                ],
                'invalid_message' => 'Veuillez réessayer',
                'required' => true,
                'trim' => true,
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'input-Civ',
                    'placeholder' => 'Mot de passe',
                ],
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être supèrieur à {{ limit }}',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
