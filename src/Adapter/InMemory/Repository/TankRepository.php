<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Pos;
use App\Entity\Tank;
use App\Gateway\TankGateway;

/**
 * Class TankRepository
 * @package App\Adapter\InMemory\Repository
 */
class TankRepository implements TankGateway
{
    /**
     * @var array
     */
    public array $tank = [];

    /**
     * TankRepository constructor.
     */
    public function __construct()
    {
        $p = (new Pos())
            ->setCode("STA0000")
            ->setName("Station TAWAAL XXXX")
            ->setDescription("description")
            ->setTown("Ville")
            ->setAddress("BP XXXX")
            ->setCapacity(60000)
            ->setActive(true)
            ->setValid(true)
            ->setUpdateAt(new \DateTimeImmutable())
            ->setValidateAt(new \DateTimeImmutable())
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $t = (new Tank($p))
            ->setCode("CUV0000")
            ->setName("Super 1")
            ->setDescription("Station TAWAAL XXXX")
            ->setCapacity(20000)
            ->setActive(true)
            ->setValid(true)
            ->setUpdateAt(new \DateTimeImmutable())
            ->setValidateAt(new \DateTimeImmutable())
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($t);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($t, 1);

        $this->tank = [1 => $t];
    }


    /**
     * @param int $id
     * @return Tank
     */
    public function findOneById(int $id): Tank
    {
        return $this->tank[$id];
    }

    /**
     * @param Tank $tank
     */
    public function create(Tank $tank): void
    {
    }
}
