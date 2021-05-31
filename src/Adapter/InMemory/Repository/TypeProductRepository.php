<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\TypeProduct;
use App\Form\InMemory\TypeProductType;
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

        $entity = (new TypeProduct())
            ->setCode("01")
            ->setName("Carburant")
            ->setDescription("Produits inflammable: Super, Gasoil, Petrole, ...")
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->typeproduct[1] = $entity;

        $entity = (new TypeProduct())
            ->setCode("02")
            ->setName("Lubrifiant")
            ->setDescription("Produits pour la lubrification des pièces en mouvement")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->typeproduct[2] =  $entity;

        $entity = (new TypeProduct())
            ->setCode("03")
            ->setName("Divers")
            ->setDescription("Autres produits pour la maintenance")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 3);

        $this->typeproduct[3] =  $entity;
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

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->typeproduct;
        if (!empty($perPage)) {
            $data = array_slice($this->typeproduct, ($page - 1) * $perPage, $perPage);
        }

        return $data;
    }

    /**
     * @return int|mixed|void
     */
    public function counter()
    {
        return count($this->typeproduct);
    }

    /**
     * @param TypeProduct $typeproduct
     */
    public function create(TypeProduct $typeproduct): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return TypeProductType::class;
    }

    /**
     * @param TypeProduct $typeproduct
     */
    public function update(TypeProduct $typeproduct): void
    {
    }

    /**
     * @param TypeProduct $typeproduct
     */
    public function remove(TypeProduct $typeproduct): void
    {
    }

    /**
     * @param TypeProduct $typeproduct
     * @param bool $status
     */
    public function activate(TypeProduct $typeproduct, bool $status): void
    {
        $typeproduct
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($typeproduct->getCreateBy())
        ;
    }

    /**
     * @param TypeProduct $typeproduct
     * @param bool $status
     */
    public function validate(TypeProduct $typeproduct, bool $status): void
    {
        $typeproduct
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($typeproduct->getCreateBy())
        ;
    }
}
