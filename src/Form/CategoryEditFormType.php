<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'attr' => [
                    'placeholder' => 'Label',
                    'class' => 'input--category'
                ],
                'label' => false,
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'button-Insc'
                ],
                'label' => 'Enregistrer'

            ])
        ;
    }
}