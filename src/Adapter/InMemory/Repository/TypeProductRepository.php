<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;

/**
 * Class TypeProductRepository
 * @package App\Adapter\InMemory\Repository
 */
class TypeProductRepository implements TypeProductGateway
{
    /**
     * @var array
     */
    public array $typeproduct = [];

    /**
     * TypeProductRepository constructor.
     */
    public function __construct()
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;
        $p = (new TypeProduct())
            ->setCode("01")
            ->setName("Carburant")
            ->setDescription("Produits inflammable: Super, Gasoil, Petrole, ...")
            ->setCreateBy($employee)

        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 1);

        $this->typeproduct[1] = $p;

        $p = (new TypeProduct())
            ->setCode("02")
            ->setName("Lubrifiant")
            ->setDescription("Produits pour la lubrification des pièces en mouvement")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 2);

        $this->typeproduct[2] =  $p;

        $p = (new TypeProduct())
            ->setCode("03")
            ->setName("Divers")
            ->setDescription("Autres produits pour la maintenance")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 3);

        $this->typeproduct[3] =  $p;
    }

    /**
     * @param int $id
     * @return TypeProduct|null
     */
    public function findOneById(int $id): ?TypeProduct
    {
        if (!array_key_exists($id, $this->typeproduct)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->typeproduct[$id];
    }

    /**
     * @return TypeProduct[]|null
     */
    public function findAll(): ?array
    {
        return $this->typeproduct;
    }

    /**
     * @param TypeProduct $typeproduct
     */
    public function create(TypeProduct $typeproduct): void
    {
    }

    /**
     * @param TypeProduct $typeproduct
     */
    public function update(TypeProduct $typeproduct): void
    {
    }

    /**
     * @param TypeProduct $typeproduct
     * @param bool $status
     */
    public function activate(TypeProduct $typeproduct, bool $status): void
    {
        $this->typeproduct[1]
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($this->typeproduct[1]->getCreateBy())
        ;
    }

    /**
     * @param TypeProduct $typeproduct
     * @param bool $status
     */
    public function validate(TypeProduct $typeproduct, bool $status): void
    {
        $this->typeproduct[1]
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($this->typeproduct[1]->getCreateBy())
        ;
    }
}