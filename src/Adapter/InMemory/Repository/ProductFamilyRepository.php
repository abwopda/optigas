<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\ProductFamily;
use App\Entity\TypeProduct;
use App\Gateway\ProductFamilyGateway;

/**
 * Class ProductFamilyRepository
 * @package App\Adapter\InMemory\Repository
 */
class ProductFamilyRepository implements ProductFamilyGateway
{
    /**
     * @var array
     */
    public array $productfamily = [];

    private TypeProductRepository $typeproduct;

    /**
     * ProductFamilyRepository constructor.
     */
    public function __construct()
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;

        $this->typeproduct = new TypeProductRepository();

        $p = (new ProductFamily($this->typeproduct->findOneById(1)))
            ->setCode("CAR")
            ->setName("Carburant")
            ->setDescription("Produits inflammable: Super, Gasoil, Petrole, ...")
            ->setCreateBy($employee)

        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 1);

        $this->productfamily[1] = $p;

        $p = (new ProductFamily($this->typeproduct->findOneById(2)))
            ->setCode("LUB")
            ->setName("Lubrifiant")
            ->setDescription("Huiles")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 2);

        $this->productfamily[2] =  $p;

        $p = (new ProductFamily($this->typeproduct->findOneById(2)))
            ->setCode("GRA")
            ->setName("Graisse")
            ->setDescription("Graisses")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 3);

        $this->productfamily[3] =  $p;

        $p = (new ProductFamily($this->typeproduct->findOneById(3)))
            ->setCode("FIL")
            ->setName("Filtre")
            ->setDescription("Filtres")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 4);

        $this->productfamily[4] =  $p;

        $p = (new ProductFamily($this->typeproduct->findOneById(3)))
            ->setCode("DET")
            ->setName("Detergent")
            ->setDescription("Detergents")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 5);

        $this->productfamily[5] =  $p;
    }

    /**
     * @param int $id
     * @return ProductFamily|null
     */
    public function findOneById(int $id): ?ProductFamily
    {
        if (!array_key_exists($id, $this->productfamily)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->productfamily[$id];
    }

    /**
     * @return ProductFamily[]|null
     */
    public function findAll(): ?array
    {
        return $this->productfamily;
    }

    /**
     * @param ProductFamily $productfamily
     */
    public function create(ProductFamily $productfamily): void
    {
    }

    /**
     * @param ProductFamily $productfamily
     */
    public function update(ProductFamily $productfamily): void
    {
    }

    /**
     * @param ProductFamily $productfamily
     * @param bool $status
     */
    public function activate(ProductFamily $productfamily, bool $status): void
    {
        $this->productfamily[1]
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($this->productfamily[1]->getCreateBy())
        ;
    }

    /**
     * @param ProductFamily $productfamily
     * @param bool $status
     */
    public function validate(ProductFamily $productfamily, bool $status): void
    {
        $this->productfamily[1]
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($this->productfamily[1]->getCreateBy())
        ;
    }
}
