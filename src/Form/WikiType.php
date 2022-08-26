<?php

namespace App\Form;

use App\Entity\Category;
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
            ->add('title', TextType::class,[
                'attr' => [
                    'placeholder' => 'Titre du Livre',
                    'class' => 'input--new--title'
                ],
                'label' => false,
            ])
            ->add('user', EntityType::class,[
                'attr' => [
                    'placeholder' => 'User',
                    'class' => 'input--new--user'
                ],
                'label' => false,
                'class' => User::class
            ])
            ->add('url', UrlType::class,[
                'attr' => [
                    'placeholder' => 'Url',
                    'class' => 'input--new--url'
                ],
                'label' => false,
            ])
            ->add('categories', EntityType::class, [
                'attr' => [
                    'placeholder' => 'Categories',
                    'class' => 'input--new--wiki'
                ],
                'mapped' => true,
                'label' => false,
                'multiple' => true,
                'expanded' => true,
                'class' => Category::class
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de couverture',
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'button--new'
                ],
                'label' => 'Générer'
            ])
        ;
    }
}