<?php
// src/Form/DateTimeImmutableType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTimeImmutableType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \DateTimeImmutable::class,
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd HH:mm:ss',
            //'format' => 'dd-MM-yyyy',
            'html5' => false,
        ));
    }

    public function getParent()
    {
        return DateTimeType::class;
    }
}





?>