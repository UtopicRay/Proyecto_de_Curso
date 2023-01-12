<?php

namespace App\Form;

use App\Entity\Investigacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvestigacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titulo')
            ->add('Facultad',ChoiceType::class, [
                'choices'  =>Investigacion::option,
            ])
            ->add('archivo',FileType::class, [
                'label' => 'Archivo (PDF file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('Catedra',ChoiceType::class, [
                'choices'  =>Investigacion::catedras,
            ])
            ->add('descripcion')
            ->add('Cancelar',ButtonType::class,['attr'=>['class'=>'btn-primary btn-user btn-block','onClick'=>'Cancelar()']])
            ->add('Aceptar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Investigacion::class,
        ]);
    }
}
