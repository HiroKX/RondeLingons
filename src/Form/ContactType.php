<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, [
                'label' => 'Nom',
                'label_attr'=>[
                    'class'=>'block mb-2 font-bold text-gray-700 dark:text-gray-400'
                ],
                'attr'=>['class'=>'block w-full px-4 py-3 mb-3 leading-tight text-gray-700 border rounded bg-gray-50 lg:mb-0 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800 ']
            ])
            ->add('prenom',TextType::class, [
                'label' => 'Prénom',
                'label_attr'=>[
                    'class'=>'block mb-2 font-bold text-gray-700 dark:text-gray-400'
                ],
                'attr'=>['class'=>'block w-full px-4 py-3 mb-3 leading-tight text-gray-700 border rounded bg-gray-50 dark:placeholder-gray-500 lg:mb-0 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800']
            ])
            ->add('email',EmailType::class, [
                'label' => 'Email',
                'label_attr'=>[
                    'class'=>'block mb-2 font-bold text-gray-700 dark:text-gray-400'
                ],
                'attr'=>['class'=>'block w-full px-4 py-3 mb-3 leading-tight text-gray-700 border rounded bg-gray-50 dark:placeholder-gray-500 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800 ']
            ])
            ->add('sujet',TextType::class, [
                'label' => 'Sujet',
                'label_attr'=>[
                    'class'=>'block mb-2 font-bold text-gray-700 dark:text-gray-400'
                ],
                'attr'=>['class'=>'block w-full px-4 py-3 mb-3 leading-tight text-gray-700 border rounded bg-gray-50 dark:placeholder-gray-500 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800 ']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Contenu',
                'label_attr'=>[
                    'class'=>'block mb-2 font-bold text-gray-700 dark:text-gray-400'
                ],
        'attr'=>['class'=>'block w-full px-4 leading-tight text-gray-700 border rounded bg-gray-50 dark:placeholder-gray-500 py-7 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800 ']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}