<?php

namespace App\Form\InMemory;

use App\Entity\TypeCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class TypeCompanyType
 * @package App\Form
 */
class TypeCompanyType extends AbstractType
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
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", TypeCompany::class);
    }
}
