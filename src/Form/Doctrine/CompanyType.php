<?php

namespace App\Form\Doctrine;

use App\Entity\Company;
use App\Entity\CompanyFamily;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('families', EntityType::class, [
                'class' => CompanyFamily::class,
                'choice_label' => 'name',
                'multiple' => true
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
