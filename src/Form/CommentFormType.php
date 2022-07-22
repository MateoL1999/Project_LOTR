<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentFormType
{
    public function buildForm(FormBuilderInterface $builder, array $option): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre',
                    'class' => 'Input--Edit--CommentTitre'
                ],
        'label' => false,

            ])
            ->add('Contenu', TextareaType::class,[
                    'attr' => [
                        'placeholder' => 'Contenu',
                        'class' => 'Input--Edit--CommentContenu'
                    ],
                    'label' => false,
            ]);
        }
    }