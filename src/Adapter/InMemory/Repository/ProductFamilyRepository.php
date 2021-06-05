<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\ProductFamily;
use App\Entity\TypeProduct;
use App\Form\InMemory\ProductFamilyType;
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

        $entity = (new ProductFamily($this->typeproduct->findOneById(1)))
            ->setCode("CAR")
            ->setName("Carburant")
            ->setDescription("Produits inflammable: Super, Gasoil, Petrole, ...")
            ->setCreateBy($employee)

        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->productfamily[1] = $entity;

        $entity = (new ProductFamily($this->typeproduct->findOneById(2)))
            ->setCode("LUB")
            ->setName("Lubrifiant")
            ->setDescription("Huiles")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->productfamily[2] =  $entity;

        $entity = (new ProductFamily($this->typeproduct->findOneById(2)))
            ->setCode("GRA")
            ->setName("Graisse")
            ->setDescription("Graisses")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 3);

        $this->productfamily[3] =  $entity;

        $entity = (new ProductFamily($this->typeproduct->findOneById(3)))
            ->setCode("FIL")
            ->setName("Filtre")
            ->setDescription("Filtres")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 4);

        $this->productfamily[4] =  $entity;

        $entity = (new ProductFamily($this->typeproduct->findOneById(3)))
            ->setCode("DET")
            ->setName("Detergent")
            ->setDescription("Detergents")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 5);

        $this->productfamily[5] =  $entity;
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

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->productfamily;

        if (!empty($entity)) {
            if ($entity === "typeproduct") {
                if (!empty($id)) {
                    $families = [];
                    $i = 1;
                    foreach ($data as $f) {
                        if ($f->getTypeProduct()->getId() == $id) {
                            //var_export($f);die;
                            $families[$i++] = $f;
                        }
                    }
                    $data = $families;
                    //var_export($families);die;
                }
            }
        }

        if (!empty($keyword)) {
            $families = [];
            $i = 1;
            foreach ($data as $f) {
                if (stripos($f->getName(), $keyword) !== false or stripos($f->getDescription(), $keyword) !== false) {
                    $families[$i++] = $f;
                }
            }
            $data = $families;
        }

        if (!empty($active)) {
            //var_export($active);die;
            if (in_array("0", $active)) {
                $families = [];
                $i = 1;
                foreach ($data as $f) {
                    if (!$f->getActive()) {
                        $families[$i++] = $f;
                    }
                }
                $data = $families;
            } else {
                $families = [];
                $i = 1;
                foreach ($data as $f) {
                    if ($f->getActive()) {
                        $families[$i++] = $f;
                    }
                }
                $data = $families;
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $families = [];
                $i = 1;
                foreach ($data as $f) {
                    if (!$f->getValid()) {
                        $families[$i++] = $f;
                    }
                }
                $data = $families;
            } else {
                $families = [];
                $i = 1;
                foreach ($data as $f) {
                    if (!$f->getValid()) {
                        $families[$i++] = $f;
                    }
                }
                $data = $families;
            }
        }

        if (!empty($perPage)) {
            $data = array_slice($data, ($page - 1) * $perPage, $perPage);
        }

        return $data;
    }

    /**
     * @return int|mixed|void
     */
    public function counter()
    {
        return count($this->productfamily);
    }

    /**
     * @param ProductFamily $productfamily
     */
    public function create(ProductFamily $productfamily): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return ProductFamilyType::class;
    }

    /**
     * @param ProductFamily $productfamily
     */
    public function update(ProductFamily $productfamily): void
    {
    }

    /**
     * @param ProductFamily $productfamily
     */
    public function remove(ProductFamily $productfamily): void
    {
    }

    /**
     * @param ProductFamily $productfamily
     * @param bool $status
     */
    public function activate(ProductFamily $productfamily, bool $status): void
    {
        $productfamily
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($productfamily->getCreateBy())
        ;
    }

    /**
     * @param ProductFamily $productfamily
     * @param bool $status
     */
    public function validate(ProductFamily $productfamily, bool $status): void
    {
        $productfamily
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($productfamily->getCreateBy())
        ;
    }
}
