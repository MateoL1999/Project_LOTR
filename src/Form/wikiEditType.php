<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class wikiEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    'placeholder' => 'Titre du Livre',
                    'class' => 'Input--Edit--Titre'
                ],
                'label' => false,
            ])
            ->add('user', EntityType::class,[
                'attr' => [
                    'placeholder' => 'User',
                    'class' => 'Input--Edit--User'
                ],
                'label' => false,
                'class' => User::class
            ])
            ->add('categories', EntityType::class, [
                'attr' => [
                    'placeholder' => 'Categories',
                    'class' => 'Input--Edit--Wiki'
                ],
                'mapped' => true,
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
                    'class' => 'bouton-New'
                ],
                'label' => 'Générer'
            ])
        ;
    }
}