<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\CompanyFamily;
use App\Entity\TypeCompany;
use App\Form\InMemory\CompanyFamilyType;
use App\Gateway\CompanyFamilyGateway;

/**
 * Class CompanyFamilyRepository
 * @package App\Adapter\InMemory\Repository
 */
class CompanyFamilyRepository implements CompanyFamilyGateway
{
    /**
     * @var array
     */
    public array $companyfamily = [];

    private TypeCompanyRepository $typecompany;

    /**
     * CompanyFamilyRepository constructor.
     */
    public function __construct()
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;

        $this->typecompany = new TypeCompanyRepository();

        $entity = (new CompanyFamily($this->typecompany->findOneById(1)))
            ->setCode("CAR01")
            ->setName("Fournisseurs Carburant")
            ->setDescription("Tous les fournisseurs de carburant")
            ->setCreateBy($employee)

        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->companyfamily[1] = $entity;

        $entity = (new CompanyFamily($this->typecompany->findOneById(1)))
            ->setCode("LUB01")
            ->setName("Fournisseurs de lubrifiants")
            ->setDescription("Tous les fournisseurs de lubrifiants")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->companyfamily[2] =  $entity;

        $entity = (new CompanyFamily($this->typecompany->findOneById(2)))
            ->setCode("CAR02")
            ->setName("Clients de carburant")
            ->setDescription("Tous les clients de carburant")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 3);

        $this->companyfamily[3] =  $entity;

        $entity = (new CompanyFamily($this->typecompany->findOneById(2)))
            ->setCode("LUB02")
            ->setName("Clients de lubrifiants")
            ->setDescription("Tous les clients de lubrifiants")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 4);

        $this->companyfamily[4] =  $entity;

        $entity = (new CompanyFamily($this->typecompany->findOneById(1)))
            ->setCode("DIV01")
            ->setName("Autres fournisseurs")
            ->setDescription("Tout autre fournisseur")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 5);

        $this->companyfamily[5] =  $entity;

        $entity = (new CompanyFamily($this->typecompany->findOneById(2)))
            ->setCode("DIV02")
            ->setName("Autres clients")
            ->setDescription("Tout autre clients")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 6);

        $this->companyfamily[6] =  $entity;

        $entity = (new CompanyFamily($this->typecompany->findOneById(3)))
            ->setCode("DIV03")
            ->setName("Sous-traitant")
            ->setDescription("Sous-traitant")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 7);

        $this->companyfamily[7] =  $entity;
    }

    /**
     * @param int $id
     * @return CompanyFamily|null
     */
    public function findOneById(int $id): ?CompanyFamily
    {
        if (!array_key_exists($id, $this->companyfamily)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->companyfamily[$id];
    }

    /**
     * @return CompanyFamily[]|null
     */
    public function findAll(): ?array
    {
        return $this->companyfamily;
    }

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->companyfamily;
        //die($id);
        if (!empty($entity)) {
            if ($entity === "typecompany") {
                if (!empty($id)) {
                    $families = [];
                    $i = 1;
                    foreach ($data as $f) {
                        //var_export($f->getTypeCompany()->getId());
                        if ($f->getTypeCompany()->getId() == $id) {
                            //var_export($f);die;
                            $families[$i++] = $f;
                        }
                    }
                    $data = $families;
                    //var_export($families);die;
                }
            }
        }

        $i = 1;
        if (!empty($ids)) {
            $companies = [];
            $i = 1;
            foreach ($data as $c) {
                if ($ids->contains($c)) {
                    $types[$i++] = $c;
                }
            }
            $data = $companies;
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
        return count($this->companyfamily);
    }

    /**
     * @param CompanyFamily $companyfamily
     */
    public function create(CompanyFamily $companyfamily): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return CompanyFamilyType::class;
    }

    /**
     * @param CompanyFamily $companyfamily
     */
    public function update(CompanyFamily $companyfamily): void
    {
    }

    /**
     * @param CompanyFamily $companyfamily
     */
    public function remove(CompanyFamily $companyfamily): void
    {
    }

    /**
     * @param CompanyFamily $companyfamily
     * @param bool $status
     */
    public function activate(CompanyFamily $companyfamily, bool $status): void
    {
        $companyfamily
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($companyfamily->getCreateBy())
        ;
    }

    /**
     * @param CompanyFamily $companyfamily
     * @param bool $status
     */
    public function validate(CompanyFamily $companyfamily, bool $status): void
    {
        $companyfamily
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($companyfamily->getCreateBy())
        ;
    }
}
