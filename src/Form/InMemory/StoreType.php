<?php

namespace App\Form\InMemory;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Pos;
use App\Entity\Product;
use App\Entity\Store;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add("products", ChoiceType::class, [
                "choices" => (new ProductRepository())->findAll(),
                "choice_label" => function ($product, $key, $value) {
                    /** @var Product $product */
                    return strtoupper($product->getCode() . "-" . $product->getName());
                },
                "multiple" => true,
                "mapped" => false,
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("poss", ChoiceType::class, [
                "choices" => (new PosRepository())->findAll(),
                "choice_label" => function ($pos, $key, $value) {
                    /** @var Pos $pos */
                    return strtoupper($pos->getCode() . "-" . $pos->getName());
                },
                "multiple" => true,
                "mapped" => false,
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
