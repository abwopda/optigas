<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Pos;
use App\Entity\Tank;
use App\Form\InMemory\TankType;
use App\Gateway\PosGateway;
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

    private PosRepository $pos;

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

        $this->pos = new PosRepository();

        $t = (new Tank($this->pos->findOneById(1)))
            ->setCode("CUV0101")
            ->setName("Super")
            ->setDescription("TAWAAL OIL AKAK")
            ->setCapacity(30000)
            ->setCreateBy($employee)
        ;

        $reflectionClass = new \ReflectionClass($t);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($t, 1);

        $this->tank[1] = $t;

        $t = (new Tank($this->pos->findOneById(1)))
            ->setCode("CUV0102")
            ->setName("Gasoil 1")
            ->setDescription("TAWAAL OIL AKAK")
            ->setCapacity(30000)
            ->setCreateBy($employee)
            ->setUpdateBy($employee)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($t);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($t, 2);

        $this->tank[2] = $t;

        $t = (new Tank($this->pos->findOneById(1)))
            ->setCode("CUV0103")
            ->setName("Gasoil 2")
            ->setDescription("TAWAAL OIL AKAK")
            ->setCapacity(15000)
            ->setCreateBy($employee)
            ->setValid(true)
            ->setValidateBy($employee)
            ->setValidateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($t);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($t, 3);

        $this->tank[3] = $t;

        $t = (new Tank($this->pos->findOneById(1)))
            ->setCode("CUV0104")
            ->setName("Petrole")
            ->setDescription("TAWAAL OIL AKAK")
            ->setCapacity(15000)
            ->setCreateBy($employee)
            ->setActive(true)
            ->setActivateBy($employee)
            ->setActivateAt(new \DateTimeImmutable())
        ;

        $reflectionClass = new \ReflectionClass($t);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($t, 4);

        $this->tank[4] = $t;
    }

    /**
     * @param int $id
     * @return Tank|null
     */
    public function findOneById(int $id): ?Tank
    {
        if (!array_key_exists($id, $this->tank)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->tank[$id];
    }

    /**
     * @return Tank[]|null
     */
    public function findAll(): ?array
    {
        return $this->tank;
    }

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->tank;
        if (!empty($perPage)) {
            $data = array_slice($this->tank, ($page - 1) * $perPage, $perPage);
        }

        return $data;
    }

    /**
     * @return int|mixed|void
     */
    public function counter()
    {
        return count($this->tank);
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return TankType::class;
    }

    /**
     * @param Tank $tank
     */
    public function create(Tank $tank): void
    {
    }

    /**
     * @param Tank $tank
     */
    public function update(Tank $tank): void
    {
    }

    /**
     * @param Tank $tank
     */
    public function remove(Tank $tank): void
    {
    }

    /**
     * @param Tank $tank
     * @param bool $status
     */
    public function activate(Tank $tank, bool $status): void
    {
        $tank
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($tank->getCreateBy())
        ;
    }

    /**
     * @param Tank $tank
     * @param bool $status
     */
    public function validate(Tank $tank, bool $status): void
    {
        $tank
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($tank->getCreateBy())
        ;
    }
}
