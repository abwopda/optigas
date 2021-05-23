<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Product;
use App\Entity\ProductFamily;
use App\Form\InMemory\ProductType;
use App\Gateway\ProductGateway;

/**
 * Class ProductRepository
 * @package App\Adapter\InMemory\Repository
 */
class ProductRepository implements ProductGateway
{
    /**
     * @var array
     */
    public array $product = [];

    private ProductFamilyRepository $productfamily;

    /**
     * ProductRepository constructor.
     */
    public function __construct()
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;

        $this->productfamily = new ProductFamilyRepository();

        $entity = (new Product($this->productfamily->findOneById(1)))
            ->setCode("CAR01")
            ->setName("Super")
            ->setDescription("Produits inflammable")
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->product[1] = $entity;

        $entity = (new Product($this->productfamily->findOneById(1)))
            ->setCode("CAR02")
            ->setName("Gasoil")
            ->setDescription("Produits inflammable")
            ->setCreateBy($employee)

        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->product[2] = $entity;

        $entity = (new Product($this->productfamily->findOneById(1)))
            ->setCode("CAR03")
            ->setName("Petrole")
            ->setDescription("Produits inflammable")
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 3);

        $this->product[3] = $entity;

        $entity = (new Product($this->productfamily->findOneById(2)))
            ->setCode("LUB01")
            ->setName("Huile 40")
            ->setDescription("Huiles")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 4);

        $this->product[4] =  $entity;

        $entity = (new Product($this->productfamily->findOneById(2)))
            ->setCode("LUB02")
            ->setName("Huile 15W40")
            ->setDescription("Huiles")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 5);

        $this->product[5] =  $entity;

        $entity = (new Product($this->productfamily->findOneById(2)))
            ->setCode("LUB03")
            ->setName("Huile 20W40")
            ->setDescription("Huiles")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 6);

        $this->product[6] =  $entity;

        $entity = (new Product($this->productfamily->findOneById(3)))
            ->setCode("GRA01")
            ->setName("Multifack")
            ->setDescription("Graisses")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 7);

        $this->product[7] =  $entity;

        $entity = (new Product($this->productfamily->findOneById(4)))
            ->setCode("FIL01")
            ->setName("Filtre Merceds 190")
            ->setDescription("Filtres")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 8);

        $this->product[8] =  $entity;

        $entity = (new Product($this->productfamily->findOneById(5)))
            ->setCode("DET01")
            ->setName("Lave glace")
            ->setDescription("Detergents")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 9);

        $this->product[9] =  $entity;
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function findOneById(int $id): ?Product
    {
        if (!array_key_exists($id, $this->product)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->product[$id];
    }

    /**
     * @return Product[]|null
     */
    public function findAll(): ?array
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function create(Product $product): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return ProductType::class;
    }

    /**
     * @param Product $product
     */
    public function update(Product $product): void
    {
    }

    /**
     * @param Product $product
     * @param bool $status
     */
    public function activate(Product $product, bool $status): void
    {
        $product
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($product->getCreateBy())
        ;
    }

    /**
     * @param Product $product
     * @param bool $status
     */
    public function validate(Product $product, bool $status): void
    {
        $product
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($product->getCreateBy())
        ;
    }
}
