<?php

namespace App\Form;

use App\Entity\Cronograma;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CronogramaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tema')
            ->add('catedra')
            ->add('fecha_ini')
            ->add('fecha_fin')
            ->add('hora_inic')
            ->add('hora_final')
            ->add('Aceptar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cronograma::class,
        ]);
    }
}
