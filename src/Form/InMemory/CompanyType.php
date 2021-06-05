<?php

namespace App\Form\InMemory;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\Company;
use App\Entity\CompanyFamily;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class CompanyType
 * @package App\Form
 */
class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("families", ChoiceType::class, [
                "choices" => (new CompanyFamilyRepository())->findAll(),
                "choice_label" => function ($family, $key, $value) {
                    /** @var CompanyFamily $family */
                    return strtoupper($family->getCode() . "-" . $family->getName());
                },
                "multiple" => true,
                "mapped" => false,
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
        $resolver->setDefault("data_class", Company::class);
    }
}
