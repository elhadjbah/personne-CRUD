<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('votre_champ_datetime', DateTimeType::class, [
                // ajouter des options pour le champ datetime ici
            ])
            ->get('votre_champ_datetime')
            ->addViewTransformer(new DateTimeTransformer());
    }
}

class DateTimeTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        // transforme la valeur en une chaîne de caractères pour l'affichage dans la vue de formulaire
        return $value instanceof \DateTimeImmutable ? $value->format('Y-m-d H:i:s') : '';
    }

    public function reverseTransform($value)
    {
        // transforme la valeur en un objet DateTimeImmutable pour l'enregistrement dans la base de données
        return new \DateTimeImmutable($value);
    }
}



?>