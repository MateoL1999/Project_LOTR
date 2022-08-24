<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class commentEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Titre du commentaire',
                    'class' => 'input--edit--commentTitle'
                ],
                'label' => false,
            ])
            ->add('user', EntityType::class,[
                'attr'=>[
                    'placeholder'=> 'Utilisateur',
                    'class' => 'input--edit--commentUser'
                ],
                'label' => false,
                'class' => User::class
            ])

            ->add('contenu', TextareaType::class,[
                'attr' => [
                    'placeholder'=>'Contenu',
                    'class' => 'input--edit--commentContent'
                ],
                'label' => false,
            ])
            ->add('save', SubmitType::class,[
                'attr'=>[
                    'class'=>'button-Insc'
                ],
                'label'=>'Modifier'
            ]);
    }
}