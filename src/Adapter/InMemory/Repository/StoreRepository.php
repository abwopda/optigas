<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Store;
use App\Entity\User;
use App\Form\InMemory\StoreType;
use App\Gateway\StoreGateway;

/**
 * Class StoreRepository
 * @package App\Adapter\InMemory\Repository
 */
class StoreRepository implements StoreGateway
{
    /**
     * @var array
     */
    public array $store = [];

    private ProductRepository $product;

    /**
     * StoreRepository constructor.
     */
    public function __construct()
    {
        $this->product = new ProductRepository();

        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;
        $entity = (new Store())
            ->setCode("01")
            ->setName("SONARA")
            ->setDescription("PCCC Limbe")
            ->setTown("Limbe")
            ->setAddress("BP AAAA")
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->store[1] = $entity;

        $entity = (new Store())
            ->setCode("02")
            ->setName("SCDP DOUALA")
            ->setDescription("Depot SCDP Douala")
            ->setTown("Douala")
            ->setAddress("BP YYYY")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->store[2] =  $entity;

        $entity = (new Store())
            ->setCode("03")
            ->setName("SCDP Yaounde")
            ->setDescription("Depot SCDP Nsam")
            ->setTown("Yaoundé")
            ->setAddress("BP YYYY")
            ->setCreateBy($employee)
            ->setUpdateBy($employee)
            ->setUpdateAt(new \DateTimeImmutable())
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 3);

        $this->store[3] =  $entity;

        $entity = (new Store())
            ->setCode("04")
            ->setName("SCDP Bafoussam")
            ->setDescription("Depot de Bafoussam")
            ->setTown("Bafoussam")
            ->setAddress("BP YYYY")
            ->setCreateBy($employee)
            ->setUpdateBy($employee)
            ->setUpdateAt(new \DateTimeImmutable())
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 4);

        $this->store[4] =  $entity;
    }

    /**
     * @param int $id
     * @return Store|null
     */
    public function findOneById(int $id): ?Store
    {
        if (!array_key_exists($id, $this->store)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->store[$id];
    }

    /**
     * @return Store[]|null
     */
    public function findAll(): ?array
    {
        return $this->store;
    }

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->store;
        $i = 1;
        if (!empty($ids)) {
            $stores = [];
            $i = 1;
            foreach ($data as $p) {
                if ($ids->contains($p)) {
                    $stores[$i++] = $p;
                }
            }
            $data = $stores;
        }

        if (!empty($keyword)) {
            //var_export($keyword);die;
            $stores = [];
            $i = 1;
            foreach ($data as $p) {
                //var_export(stripos($p->getName(),$keyword));
                if (stripos($p->getName(), $keyword) !== false or stripos($p->getDescription(), $keyword) !== false) {
                    $stores[$i++] = $p;
                }
            }
            //die;
            $data = $stores;
        }

        if (!empty($active)) {
            //var_export($active);die;
            if (in_array("0", $active)) {
                $stores = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getActive()) {
                        $stores[$i++] = $p;
                    }
                }
                $data = $stores;
            } else {
                $stores = [];
                $i = 1;
                foreach ($data as $p) {
                    if ($p->getActive()) {
                        $stores[$i++] = $p;
                    }
                }
                $data = $stores;
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $stores = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getValid()) {
                        $stores[$i++] = $p;
                    }
                }
                $data = $stores;
            } else {
                $stores = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getValid()) {
                        $stores[$i++] = $p;
                    }
                }
                $data = $stores;
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
        return count($this->store);
    }

    /**
     * @param Store $store
     */
    public function create(Store $store): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return StoreType::class;
    }

    /**
     * @param Store $store
     */
    public function update(Store $store): void
    {
    }

    /**
     * @param Store $store
     */
    public function remove(Store $store): void
    {
    }

    /**
     * @param Store $store
     * @param bool $status
     */
    public function activate(Store $store, bool $status): void
    {
        $store
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($store->getCreateBy())
        ;
    }

    /**
     * @param Store $store
     * @param bool $status
     */
    public function validate(Store $store, bool $status): void
    {
        $store
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($this->store[1]->getCreateBy())
        ;
    }
}
