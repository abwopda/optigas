<?php

namespace App\Form;

use App\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("the_key", TextType::class, [
                "label" => "the_key",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("the_value", TextareaType::class, [
                "label" => "the_value",
                "constraints" => [
                    new NotBlank()
                ]
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Config::class
        ));
    }

    public function getName()
    {
        return "configtype";
    }
}
