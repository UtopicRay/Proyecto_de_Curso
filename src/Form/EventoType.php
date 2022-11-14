<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Time;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nombre', TextType::class, ['attr' =>
                ['class' => ' form-control-user',
                    'required' => '']
            ])
            ->add('Tematica', ChoiceType::class, [
                'choices' => Evento::TIPOS,
                'attr'=>['class'=>'btn-user btn']])
            ->add('fecha_ini', DateType::class, ['attr' => ['required' => '']])
            ->add('fecha_fin', DateType::class, ['attr' => ['required' => '']])
            ->add('hora_inic', TimeType::class, ['attr' => ['required' => '']])
            ->add('hora_fin', TimeType::class, ['attr' => ['required' => '']])
            ->add('Aceptar', SubmitType::class,[
                'attr'=>['class'=>'btn-primary btn-user btn-block']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
