<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'attr' => [
                    'placeholder' => 'Ex: 9780439708180',
                ],
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre du livre',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Résumé éditorial, ambiance, points forts...',
                ],
            ])
            ->add('imageUrl', UrlType::class, [
                'label' => 'Image de couverture (URL)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://...',
                ],
            ])
            ->add('nombre_pages', IntegerType::class, [
                'label' => 'Nombre de pages',
                'attr' => [
                    'placeholder' => 'Nombre total de pages',
                    'min' => 1,
                ],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'attr' => [
                    'placeholder' => '14.90',
                    'min' => 0,
                    'step' => '0.01',
                ],
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock',
                'attr' => [
                    'placeholder' => 'Quantité disponible',
                    'min' => 0,
                ],
            ])
            ->add('date_de_parution', DateType::class, [
                'label' => 'Date de parution',
                'widget' => 'single_text',
            ])
            ->add('note', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '1/20' => 1,
                    '2/20' => 2,
                    '3/20' => 3,
                    '4/20' => 4,
                    '5/20' => 5,
                    '6/20' => 6,
                    '7/20' => 7,
                    '8/20' => 8,
                    '9/20' => 9,
                    '10/20' => 10,
                    '11/20' => 11,
                    '12/20' => 12,
                    '13/20' => 13,
                    '14/20' => 14,
                    '15/20' => 15,
                    '16/20' => 16,
                    '17/20' => 17,
                    '18/20' => 18,
                    '19/20' => 19,
                    '20/20' => 20,
                ],
            ])
            ->add('auteurs', null, [
                'label' => 'Auteurs',
                'attr' => [
                    'multiple' => true,
                ],
            ])
            ->add('genres', null, [
                'label' => 'Genres',
                'attr' => [
                    'multiple' => true,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
