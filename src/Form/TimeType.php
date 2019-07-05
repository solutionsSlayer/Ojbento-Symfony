<?php

namespace App\Form;

use App\Entity\Time;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeType extends AbstractType
{
    public function getBlockPrefix()
    {
        return "ticket_time_type";
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hour_command')
            ->add('value')
            ->add('midi')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Time::class,
        ]);
    }
}
