<?php

namespace App\Form\InMemory;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\Entity\Tank;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class TankType
 * @package App\Form
 */
class TankType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("pos", ChoiceType::class, [
                "choices" => (new PosRepository())->findAll(),
                "choice_label" => function ($pos, $key, $value) {
                    /** @var Pos $pos */
                    return strtoupper($pos->getCode() . "-" . $pos->getName());
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
            ->add("capacity", NumberType::class, [
                "label" => "Capacité",
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
        $resolver->setDefault("data_class", Tank::class);
    }
}
