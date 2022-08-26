<?php

namespace App\Form;

use App\Entity\Category;
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
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'Search--Titre',
                    'placeholder' => 'Titre',
                ],
                'required' => false,
                'label' => false,

            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'placeholder' => '--Catégorie--',
                'required' => false,
                'label' => false,

            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'button-submit'
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