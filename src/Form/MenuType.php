<?php

namespace App\Form;

use App\Entity\Menu;
use App\Form\PricemenuType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isMidi')
            ->add('assocs',CollectionType::class, [
                'entry_type' => AssocType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => array('class' => 'assoc')
                ],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('prices', CollectionType::class, [
                'entry_type' => PricemenuType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => array('class' => 'prices')
                ],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
