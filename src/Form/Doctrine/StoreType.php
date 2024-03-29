<?php

namespace App\Form\Doctrine;

use App\Entity\Pos;
use App\Entity\Product;
use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class StoreType
 * @package App\Form
 */
class StoreType extends AbstractType
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
            ->add("products", EntityType::class, [
                "by_reference" => false,
                "class" => Product::class,
                "choice_label" => "name",
                "multiple" => true,
                "required" => false,
            ])
            ->add("poss", EntityType::class, [
                "by_reference" => false,
                "class" => Pos::class,
                "choice_label" => "name",
                "multiple" => true,
                "required" => false,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Store::class);
    }
}
