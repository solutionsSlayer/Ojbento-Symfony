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



            ->add('type', EntityType::class,[
                "class" => Type::class,
                'attr' => array('class' => 'form-control test')])

            ->add('product', EntityType::class, [
                "class" => Product::class,
                'attr' => array('class' => 'form-control')])

            ->add('quantity', null, [
                'attr' => array('class' => 'form-control')
            ])
            ->add('image', ImageType::class, [
                'required' => false,
                'attr' => array('class' => 'forAssoc'),
                'label_attr' => array('class' => 'forAssoc')
            ])
            ->add('isDish', null,[
                'attr' => array('class' => 'forAssoc'),
                'label_attr' => array('class' => 'forAssoc'),])


            ->add('description',null,[
                'attr' => array('class' => 'form-control forAssoc', 'row'=>'3'),
                'label_attr' => array('class' => 'forAssoc')])

            ->add('composition',null,[
                'attr' => array('class' => 'form-control forAssoc', 'row'=>'3'),
                'label_attr' => array('class' => 'forAssoc')])

            ->add('prices', CollectionType::class, [
                'label_attr' => array('class' => 'forAssoc'),
                'entry_type' => PriceassocType::class,
                'entry_options' => [
                    'attr' => array('class' => 'prices','forAssoc' ),
                    'label_attr' => array('class' => 'd-none'),
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
