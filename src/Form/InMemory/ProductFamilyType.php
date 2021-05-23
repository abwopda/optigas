<?php

namespace App\Form\InMemory;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\ProductFamily;
use App\Entity\TypeProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ProductFamilyType
 * @package App\Form
 */
class ProductFamilyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("typeproduct", ChoiceType::class, [
                "choices" => (new TypeProductRepository())->findAll(),
                "choice_label" => function ($typeproduct, $key, $value) {
                    /** @var TypeProduct $typeproduct */
                    return strtoupper($typeproduct->getCode() . "-" . $typeproduct->getName());
                },
                "constraints" => [
                    new NotBlank()
                ]
            ])
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
        $resolver->setDefault("data_class", ProductFamily::class);
    }
}
