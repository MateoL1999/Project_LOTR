<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WikiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    'placeholder' => 'Titre du Livre',
                    'class' => 'Input--New--Titre'
                ],
                'label' => false,
            ])
            ->add('user', EntityType::class,[
                'attr' => [
                    'placeholder' => 'User',
                    'class' => 'Input--New--User'
                ],
                'label' => false,
                'class' => User::class
            ])
            ->add('url', UrlType::class,[
                'attr' => [
                    'placeholder' => 'Url',
                    'class' => 'Input--New--Url'
                ],
                'label' => false,
            ])
            ->add('categories', EntityType::class, [
                'attr' => [
                    'placeholder' => 'Categories',
                    'class' => 'Input--New--Wiki'
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
                'label' => 'G??n??rer'
            ])
        ;
    }
}