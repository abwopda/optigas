<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Pump;
use App\Gateway\PumpGateway;

/**
 * Class PumpRepository
 * @package App\Adapter\InMemory\Repository
 */
class PumpRepository implements PumpGateway
{
    /**
     * @var array
     */
    public array $pump = [];

    private TankRepository $tank;

    public function create(Pump $pump): void
    {
    }

    /**
     * @param int $id
     * @return Pump|null
     */
    public function findOneById(int $id): ?Pump
    {
        if (!array_key_exists($id, $this->pump)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->pump[$id];
    }

    /**
     * TankRepository constructor.
     */
    public function __construct()
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;

        $this->tank = new TankRepository();

        for ($i = 1; $i <= 5; $i++) {
            $p = (new Pump($this->tank->findOneById(1)))
                ->setCode("P010" . $i)
                ->setName("Super " . $i)
                ->setDescription("Super")
                ->setCreateBy($employee)
            ;

            $reflectionClass = new \ReflectionClass($p);
            $reflectionProperty = $reflectionClass->getProperty("id");
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($p, $i);

            $this->pump[$i] = $p;
        }
        for ($i = 1; $i <= 4; $i++) {
            $p = (new Pump($this->tank->findOneById(2)))
                ->setCode("P010" . $i)
                ->setName("Gasoil " . $i)
                ->setDescription("Gasoil")
                ->setCreateBy($employee)
            ;

            $reflectionClass = new \ReflectionClass($p);
            $reflectionProperty = $reflectionClass->getProperty("id");
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($p, $i + 5);

            $this->pump[$i + 5] = $p;
        }

        $p = (new Pump($this->tank->findOneById(3)))
            ->setCode("P0110")
            ->setName("Gasoil 5")
            ->setDescription("Gasoil")
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 10);

        $this->pump[10] = $p;

        $p = (new Pump($this->tank->findOneById(4)))
            ->setCode("P0111")
            ->setName("Petrole")
            ->setDescription("Petrole")
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($p);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($p, 11);

        $this->pump[11] = $p;
    }

    /**
     * @param Pump $pump
     */
    public function update(Pump $pump): void
    {
    }
}
