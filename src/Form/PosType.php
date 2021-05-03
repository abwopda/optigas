<?php

namespace App\Form;

use App\Entity\Pos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class PosType
 * @package App\Form
 */
class PosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("code", TextType::class, [
                "label" => "Code",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("name", TextType::class, [
                "label" => "Designation",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("description", TextareaType::class, [
                "label" => "Description",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("address", TextareaType::class, [
                "label" => "Adresse",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("town", TextType::class, [
                "label" => "Ville",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("capacity", NumberType::class, [
                "label" => "Capacité",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add('active', CheckboxType::class, [
                "label" => "Activé ?",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add('valid', CheckboxType::class, [
                "label" => "Validé ?",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add('updateAt', DateTimeType::class, [
                "label" => "Modifié le",
                "constraints" => [
                    new NotBlank()
                ]
            ])

            ->add('activateAt', DateTimeType::class, [
                "label" => "Activé le ",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add('validateAt', DateTimeType::class, [
                "label" => "Validé le ",
                "constraints" => [
                    new NotBlank()
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Pos::class);
    }
}
