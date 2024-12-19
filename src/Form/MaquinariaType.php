<?php

namespace App\Form;

use App\Entity\Maquinaria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints as Assert;

class MaquinariaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre de la maquinaria',
            ])
            ->add('marca', TextType::class, [
                'label' => 'Marca de la maquinaria',
            ])
            ->add('descripcion', TextType::class, [
                'label' => 'Descripción',
            ])
            ->add('cantidad', IntegerType::class, [
                'label' => 'Meses de uso',
                'attr' => [
                    'class' => 'form-control',
                    'min' => '0',
                    'max' => '11',
                    'type' => 'number',
                    'message' => 'Admite valores entre 0 y 11'
                ]
            ])
            ->add('aniosUso', IntegerType::class, [
                'label' => 'Años de uso',
                'attr' => [
                    'class' => 'form-control',
                    'min' => '0',
                    'type' => 'number'
                ]
            ])
            ->add('ultimoService', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Ultimo service (opcional)',
                'required' => false,
                'constraints' => [
                    new LessThanOrEqual([
                        'value' => 'today',
                        'message' => 'La fecha no puede ser futura'
                    ])
                ],
                'attr' => [
                    'max' => (new \DateTime())->format('Y-m-d')
                ]
            ])
            ->add('imagen', FileType::class, [
                'label' => 'Imagen de la maquinaria (opcional)',
                'required' => false,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maquinaria::class,
        ]);
    }
}
