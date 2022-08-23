<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre',
                    'class' => 'Input--New--CommentTitre'
                ],
        'label' => false,

            ])
            ->add('Contenu', TextareaType::class,[
                    'attr' => [
                        'placeholder' => 'Contenu',
                        'class' => 'Input--New--CommentContenu'
                    ],
                    'label' => false,
            ])
            ->add('save', SubmitType::class,[
                'attr' => [
                    'class' => 'button-Insc'
                ],
                'label' => 'Enregistrer'
            ]);
        }
    }