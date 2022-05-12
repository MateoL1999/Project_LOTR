<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
                'label' => false
            ])

            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'input-Civ Insc--lastName',
                    'placeholder' => 'Nom'
                ],
                'label' => false
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input-format Insc--email',
                    'placeholder' => 'Email'
                ],
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
                    ]),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'input-Civ',
                    'placeholder' => 'Password',
                ],
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Mot de passe trop court {{ limit }}',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],

            ])

//            ->add('ConfirmPass', PasswordType::class, [
//                // instead of being set onto the object directly,
//                // this is read and encoded in the controller
//                'mapped' => false,
//                'attr' => [
//                    'autocomplete' => 'new-password',
//                    'class' => 'input-Insc',
//                    'placeholder' => 'Password',
//                ],
//                'label' => false,
//                'constraints' => [
//
//                   ],
//
//                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
