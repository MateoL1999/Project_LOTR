<?php

namespace App\Form;



use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormTypeInterface|\Symfony\Component\Form\FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'input-Edit Input--Edit--Prénom',
                    'palceholder' => 'Prénom',
                ],
                'label' => false
            ])
            ->add('lastName', TextType::class,[
                'attr' => [
                    'class' => 'input-Edit Input--Edit--Nom',
                    'palceholder' => 'Nom',
                ],
                'label' => false
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'Input--Edit--Email',
                    'placeholder' => 'Email',
                ],
                'label' => false
            ])
            ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Utilisateur'=>'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN'
                    ],
                    'expanded' => true,
                    'multiple'=> true,
                    'label' => 'Rôles',
                    'label_attr' => [
                            'class' => 'checkbox-inline',
                    ],
            ])

            ->add('save', SubmitType::class,[
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'bouton-Edit'
                ]
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