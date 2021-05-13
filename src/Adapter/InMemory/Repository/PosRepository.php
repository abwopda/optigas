<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Pos;
use App\Gateway\PosGateway;

/**
 * Class PosRepository
 * @package App\Adapter\InMemory\Repository
 */
class PosRepository implements PosGateway
{
    /**
     * @var array
     */
    public array $pos = [];

    /**
     * PosRepository constructor.
     */
    public function __construct()
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;
        $p = (new Pos())
            ->setCode("STA0000")
            ->setName("Station TAWAAL XXXX")
            ->setDescription("description")
            ->setTown("Ville")
            ->setAddress("BP XXXX")
            ->setCapacity(60000)
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 1);

        $this->pos = [1 => $p];

        /*$p = (new Pos())
            ->setCode("STA0001")
            ->setName("Station TAWAAL YYYY")
            ->setDescription("blablabla")
            ->setTown("Ville B")
            ->setAddress("BP YYYY")
            ->setCapacity(12000)
            ->setCreateBy($employee)
        ;
        */
    }

    /**
     * @param int $id
     * @return Pos
     */
    public function findOneById(int $id): Pos
    {
        return $this->pos[$id];
    }

    /**
     * @param Pos $pos
     */
    public function create(Pos $pos): void
    {
    }
}
