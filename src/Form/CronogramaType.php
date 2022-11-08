<?php

namespace App\Form;

use App\Entity\Cronograma;
use App\Entity\Investigacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class CronogramaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tema', TextType::class, [
                'attr' => ['class' => 'form-control',
                    'required' => '',
                    'placeholder' => 'Tema de la actividad']])
            ->add('catedra', ChoiceType::class, [
                'choices' => Investigacion::catedras,
                'attr' => ['class' => 'form-control',
                    'required' => '']
            ])
            ->add('fecha_ini', DateType::class, ['attr' => ['required' => '']])
            ->add('fecha_fin', DateType::class, ['attr' => ['required' => '']])
            ->add('hora_inic', TimeType::class, ['attr' => ['required' => '']])
            ->add('hora_final', TimeType::class, ['attr' => ['required' => '']])
            ->add('Aceptar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cronograma::class,
        ]);
    }
}
