<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WikiSearchFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'input-Edit Search--Titre',
                    'palceholder' => 'Tire',
                ],
                'required' => false

            ])
            ->add('categories', EntityType::class, [
                'label' => 'Categories',
                'class' => Categorie::class,
                'placeholder' => '--Sélectionner--',
                'required' => false

            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'bouton-submit'
                ],
                'label' => 'Générer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

}