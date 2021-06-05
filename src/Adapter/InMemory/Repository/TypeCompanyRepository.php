<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\TypeCompany;
use App\Form\InMemory\TypeCompanyType;
use App\Gateway\TypeCompanyGateway;

/**
 * Class TypeCompanyRepository
 * @package App\Adapter\InMemory\Repository
 */
class TypeCompanyRepository implements TypeCompanyGateway
{
    /**
     * @var array
     */
    public array $typecompany = [];

    /**
     * TypeCompanyRepository constructor.
     */
    public function __construct()
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;

        $entity = (new TypeCompany())
            ->setCode("01")
            ->setName("Fournisseur")
            ->setDescription("Tous les fournisseurs")
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->typecompany[1] = $entity;

        $entity = (new TypeCompany())
            ->setCode("02")
            ->setName("Clients")
            ->setDescription("Tous les clients")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->typecompany[2] =  $entity;

        $entity = (new TypeCompany())
            ->setCode("03")
            ->setName("Sous-traitants")
            ->setDescription("Autres partenaires")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 3);

        $this->typecompany[3] =  $entity;
    }

    /**
     * @param int $id
     * @return TypeCompany|null
     */
    public function findOneById(int $id): ?TypeCompany
    {
        if (!array_key_exists($id, $this->typecompany)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->typecompany[$id];
    }

    /**
     * @return TypeCompany[]|null
     */
    public function findAll(): ?array
    {
        return $this->typecompany;
    }

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->typecompany;
        $i = 1;
        if (!empty($ids)) {
            $types = [];
            $i = 1;
            foreach ($data as $t) {
                if ($ids->contains($t)) {
                    $types[$i++] = $t;
                }
            }
            $data = $types;
        }

        if (!empty($keyword)) {
            //var_export($keyword);die;
            $types = [];
            $i = 1;
            foreach ($data as $t) {
                //var_export(stripos($t->getName(),$keyword));
                if (stripos($t->getName(), $keyword) !== false or stripos($t->getDescription(), $keyword) !== false) {
                    $types[$i++] = $t;
                }
            }
            //die;
            $data = $types;
        }

        if (!empty($active)) {
            //var_export($active);die;
            if (in_array("0", $active)) {
                $types = [];
                $i = 1;
                foreach ($data as $t) {
                    if (!$t->getActive()) {
                        $types[$i++] = $t;
                    }
                }
                $data = $types;
            } else {
                $types = [];
                $i = 1;
                foreach ($data as $t) {
                    if ($t->getActive()) {
                        $types[$i++] = $t;
                    }
                }
                $data = $types;
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $types = [];
                $i = 1;
                foreach ($data as $t) {
                    if (!$t->getValid()) {
                        $types[$i++] = $t;
                    }
                }
                $data = $types;
            } else {
                $types = [];
                $i = 1;
                foreach ($data as $t) {
                    if (!$t->getValid()) {
                        $types[$i++] = $t;
                    }
                }
                $data = $types;
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
        return count($this->typecompany);
    }

    /**
     * @param TypeCompany $typecompany
     */
    public function create(TypeCompany $typecompany): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return TypeCompanyType::class;
    }

    /**
     * @param TypeCompany $typecompany
     */
    public function update(TypeCompany $typecompany): void
    {
    }

    /**
     * @param TypeCompany $typecompany
     */
    public function remove(TypeCompany $typecompany): void
    {
    }

    /**
     * @param TypeCompany $typecompany
     * @param bool $status
     */
    public function activate(TypeCompany $typecompany, bool $status): void
    {
        $typecompany
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($typecompany->getCreateBy())
        ;
    }

    /**
     * @param TypeCompany $typecompany
     * @param bool $status
     */
    public function validate(TypeCompany $typecompany, bool $status): void
    {
        $typecompany
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($typecompany->getCreateBy())
        ;
    }
}
