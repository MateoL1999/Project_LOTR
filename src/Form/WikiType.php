<?php

namespace App\Form;

use App\Entity\BookKind;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WikiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => 'Titre du livre',
                'attr' => [
                    'placeholder' => 'Titre du Livre',
                    'class' => 'Input--New--Book'
                ]
            ])
            ->add('user', EntityType::class,[
                'attr' => [
                    'placeholder' => 'User',
                    'class' => 'Input--New--Book'
                ],
                'label' => false,
                'class' => User::class
            ])
            ->add('categorie', EntityType::class, [
                'attr' => [
                    'placeholder' => 'Categorie',
                    'class' => 'Input--New--Book'
                ],
                'label' => false,
                'multiple' => true,
                'expanded' => true,
                'class' => Categorie::class
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de couverture',
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'bouton-Edit'
                ],
                'label' => 'Générer'
            ])
        ;
    }
}