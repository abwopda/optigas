<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Company;
use App\Entity\CompanyFamily;
use App\Form\InMemory\CompanyType;
use App\Gateway\CompanyGateway;

/**
 * Class CompanyRepository
 * @package App\Adapter\InMemory\Repository
 */
class CompanyRepository implements CompanyGateway
{
    /**
     * @var array
     */
    public array $company = [];

    private CompanyFamilyRepository $companyfamily;

    /**
     * CompanyRepository constructor.
     */
    public function __construct()
    {
        $this->companyfamily = new CompanyFamilyRepository();

        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;

        $entity = (new Company())
            ->setCode("FOU01")
            ->setName("SONARA")
            ->setDescription("Societe Nationale de Rafinage")
            ->setCreateBy($employee)
            ->addFamily($this->companyfamily->findOneById(1))
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->company[1] = $entity;

        $entity = (new Company())
            ->setCode("FOU02")
            ->setName("Green Oil Sarl")
            ->setDescription("Societe de distribution des produits pétroliers")
            ->setCreateBy($employee)
            ->addFamily($this->companyfamily->findOneById(1))
            ->addFamily($this->companyfamily->findOneById(3))
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->company[2] = $entity;

        $entity = (new Company())
            ->setCode("FOU03")
            ->setName("Confex Oil")
            ->setDescription("Societe de distribution des produits pétroliers")
            ->setCreateBy($employee)
            ->addFamily($this->companyfamily->findOneById(1))
            ->addFamily($this->companyfamily->findOneById(3))
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 3);

        $this->company[3] = $entity;

        $entity = (new Company())
            ->setCode("CLI001")
            ->setName("SOTRACOM")
            ->setDescription("Societe de transport")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily->findOneById(3))
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 4);

        $this->company[4] =  $entity;

        $entity = (new Company())
            ->setCode("CLI002")
            ->setName("STE NDZOMOU & BWAJ")
            ->setDescription("Societe de transport")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily->findOneById(1))
            ->addFamily($this->companyfamily->findOneById(3))
            ->addFamily($this->companyfamily->findOneById(4))
            ->addFamily($this->companyfamily->findOneById(7))
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 5);

        $this->company[5] =  $entity;

        $entity = (new Company())
            ->setCode("CLI003")
            ->setName("Carriere Chinois")
            ->setDescription("Societe de Carriere")
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily->findOneById(3))
            ->addFamily($this->companyfamily->findOneById(4))
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 6);

        $this->company[6] =  $entity;

        $entity = (new Company())
            ->setCode("FOU04")
            ->setName("ELOI SERVICES")
            ->setDescription("Societe de MOUAMOUA")
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily->findOneById(1))
            ->addFamily($this->companyfamily->findOneById(3))
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 7);

        $this->company[7] =  $entity;
    }

    /**
     * @param int $id
     * @return Company|null
     */
    public function findOneById(int $id): ?Company
    {
        if (!array_key_exists($id, $this->company)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->company[$id];
    }

    /**
     * @return Company[]|null
     */
    public function findAll(): ?array
    {
        return $this->company;
    }

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->company;

        if (!empty($entity)) {
            if ($entity === "typecompany") {
                if (!empty($id)) {
                    //var_export($type);die;
                    $companies = [];
                    $i = 1;
                    foreach ($data as $c) {
                        foreach ($c->getFamilies() as $f) {
                            if ($f->getTypeCompany()->getId() == $id) {
                                $companies[$i++] = $c;
                            }
                        }
                    }
                    $data = $companies;
                    //var_export($companies);die;
                }
            }
        }

        if (!empty($entity)) {
            if ($entity === "companyfamily") {
                if (!empty($id)) {
                    $f = $this->companyfamily->findOneById($id);
                    //var_export($f);die;
                    $companies = [];
                    $i = 1;
                    foreach ($data as $c) {
                        //var_export($c->getFamilies());
                        if ($c->getFamilies()->contains($f)) {
                            $companies[$i++] = $c;
                        }
                    }
                    //die();
                    $data = $companies;
                    //var_export($companies);die;
                }
            }
        }

        $i = 1;
        if (!empty($ids)) {
            $companies = [];
            $i = 1;
            foreach ($data as $c) {
                if ($ids->contains($c)) {
                    $companies[$i++] = $c;
                }
            }
            $data = $companies;
        }

        if (!empty($keyword)) {
            $companies = [];
            $i = 1;
            foreach ($data as $c) {
                if (stripos($c->getName(), $keyword) !== false or stripos($c->getDescription(), $keyword) !== false) {
                    $companies[$i++] = $c;
                }
            }
            $data = $companies;
        }

        if (!empty($active)) {
            //var_export($active);die;
            if (in_array("0", $active)) {
                $companies = [];
                $i = 1;
                foreach ($data as $c) {
                    if (!$c->getActive()) {
                        $companies[$i++] = $c;
                    }
                }
                $data = $companies;
            } else {
                $companies = [];
                $i = 1;
                foreach ($data as $c) {
                    if ($c->getActive()) {
                        $companies[$i++] = $c;
                    }
                }
                $data = $companies;
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $companies = [];
                $i = 1;
                foreach ($data as $c) {
                    if (!$c->getValid()) {
                        $companies[$i++] = $c;
                    }
                }
                $data = $companies;
            } else {
                $companies = [];
                $i = 1;
                foreach ($data as $c) {
                    if (!$c->getValid()) {
                        $companies[$i++] = $c;
                    }
                }
                $data = $companies;
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
        return count($this->company);
    }

    /**
     * @param Company $company
     */
    public function create(Company $company): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return CompanyType::class;
    }

    /**
     * @param Company $company
     */
    public function update(Company $company): void
    {
    }

    /**
     * @param Company $company
     */
    public function remove(Company $company): void
    {
    }

    /**
     * @param Company $company
     * @param bool $status
     */
    public function activate(Company $company, bool $status): void
    {
        $company
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($company->getCreateBy())
        ;
    }

    /**
     * @param Company $company
     * @param bool $status
     */
    public function validate(Company $company, bool $status): void
    {
        $company
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($company->getCreateBy())
        ;
    }
}
