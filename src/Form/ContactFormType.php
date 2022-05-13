<?php
//
//namespace App\Form;
//
//use App\Entity\User;
//use Doctrine\DBAL\Types\TextType;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\EmailType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;
//
//class contactFormType extends AbstractType
//{
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('email', EmailType::class,[
//                'attr' => [
//                    'class' => 'Input--Contact--Email',
//                    'placeholder' => 'Email',
//                ],
//                'label' => false
//            ])
//            ->add('objet', TextType::class, [
//                'attr'=> [
//                    'class' => 'Input--Contact--Objet',
//                    'palceholder' => 'Objet',
//                ],
//                'label' => false
//            ])
//            ->add('message', TextType::class,[
//                'attr' => [
//                    'class' => 'Input--Contact--Message',
//                    'placeholder' => 'Message',
//                ]
//                ])
//            ->add('save', SubmitType::class,[
//                 'label'=> 'Enregistrer'
//            ]);
//    }
//
//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//        ]);
//    }
//}