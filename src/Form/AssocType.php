<?php

namespace App\Form;

use App\Entity\Assoc;
use App\Form\AllergenType;
use App\Entity\Image;
use App\Entity\Allergen;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Type;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class AssocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('forMenu', HiddenType::class,[
                    'attr' => array('class' => 'forMenu')])


            ->add('product', EntityType::class, [
                "class" => Product::class
                    ])
            ->add('type', EntityType::class,[
                "class" => Type::class
            ])
            ->add('quantity')
            ->add('image', ImageType::class, [
                'required' => false
            ])
            ->add('isDish')


            ->add('description')
            ->add('composition')
            ->add('prices', CollectionType::class, [
                'entry_type' => PriceassocType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => array('class' => 'prices')
                ],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('allergens', EntityType::class,[
                'class'=> Allergen::class,
                'expanded'=> true,
                'multiple'=> true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assoc::class,
        ]);
    }
}
