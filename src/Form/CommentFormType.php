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
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre',
                    'class' => 'input--new--commentTitle'
                ],
        'label' => false,

            ])
            ->add('Content', TextareaType::class,[
                    'attr' => [
                        'placeholder' => 'Contenu',
                        'class' => 'input--new--commentContent'
                    ],
                    'label' => false,
            ])
            ->add('save', SubmitType::class,[
                'attr' => [
                    'class' => 'button-insc'
                ],
                'label' => 'Enregistrer'
            ]);
        }
    }