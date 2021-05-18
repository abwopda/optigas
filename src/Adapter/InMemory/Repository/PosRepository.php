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
            ->setCode("01")
            ->setName("TAWAAL OIL AKAK")
            ->setDescription("Station Service")
            ->setTown("Yaounde")
            ->setAddress("BP 12570")
            ->setCapacity(90000)
            ->setCreateBy($employee)

        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 1);

        $this->pos[1] = $p;

        $p = (new Pos())
            ->setCode("02")
            ->setName("TAWAAL OIL SANGMELIMA")
            ->setDescription("Station Service")
            ->setTown("Sangmelima")
            ->setAddress("BP YYYY")
            ->setCapacity(80000)
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 2);

        $this->pos[2] =  $p;

        $p = (new Pos())
            ->setCode("03")
            ->setName("TAWAAL OIL NGOYA 1")
            ->setDescription("Station Service")
            ->setTown("Ngoya")
            ->setAddress("BP YYYY")
            ->setCapacity(7000)
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 3);

        $this->pos[3] =  $p;
    }

    /**
     * @param int $id
     * @return Pos|null
     */
    public function findOneById(int $id): ?Pos
    {
        if (!array_key_exists($id, $this->pos)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->pos[$id];
    }

    /**
     * @param Pos $pos
     */
    public function create(Pos $pos): void
    {
    }

    /**
     * @param Pos $pos
     */
    public function update(Pos $pos): void
    {
    }

    /**
     * @param Pos $pos
     * @param bool $status
     */
    public function activate(Pos $pos, bool $status): void
    {
        $this->pos[1]
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($this->pos[1]->getCreateBy())
        ;
    }
}
