<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Pump;
use App\Form\InMemory\PumpType;
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
     * @return string
     */
    public function getTypeClass(): string
    {
        return PumpType::class;
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
     * @return Pump[]|null
     */
    public function findAll(): ?array
    {
        return $this->pump;
    }

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->pump;
        if (!empty($entity)) {
            if ($entity === "pos") {
                if (!empty($id)) {
                    $pumps = [];
                    $i = 1;
                    foreach ($data as $p) {
                        if ($p->getTank()->getPos()->getId() == $id) {
                            $pumps[$i++] = $p;
                        }
                    }
                    $data = $pumps;
                }
            }
        }

        if (!empty($entity)) {
            if ($entity === "tank") {
                if (!empty($id)) {
                    $pumps = [];
                    $i = 1;
                    foreach ($data as $p) {
                        if ($p->getTank()->getId() == $id) {
                            $pumps[$i++] = $p;
                        }
                    }
                    $data = $pumps;
                    //var_export($pumps);die;
                }
            }
        }

        $i = 1;
        if (!empty($ids)) {
            $pumps = [];
            $i = 1;
            foreach ($data as $p) {
                if ($ids->contains($p)) {
                    $pumps[$i++] = $p;
                }
            }
            $data = $pumps;
        }

        if (!empty($keyword)) {
            $pumps = [];
            $i = 1;
            foreach ($data as $p) {
                if (stripos($p->getName(), $keyword) !== false or stripos($p->getDescription(), $keyword) !== false) {
                    $pumps[$i++] = $p;
                }
            }
            $data = $pumps;
        }

        if (!empty($active)) {
            //var_export($active);die;
            if (in_array("0", $active)) {
                $pumps = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getActive()) {
                        $pumps[$i++] = $p;
                    }
                }
                $data = $pumps;
            } else {
                $pumps = [];
                $i = 1;
                foreach ($data as $p) {
                    if ($p->getActive()) {
                        $pumps[$i++] = $p;
                    }
                }
                $data = $pumps;
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $pumps = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getValid()) {
                        $pumps[$i++] = $p;
                    }
                }
                $data = $pumps;
            } else {
                $pumps = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getValid()) {
                        $pumps[$i++] = $p;
                    }
                }
                $data = $pumps;
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
        return count($this->pump);
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

    /**
     * @param Pump $pump
     */
    public function remove(Pump $pump): void
    {
    }

    /**
     * @param Pump $pump
     * @param bool $status
     */
    public function activate(Pump $pump, bool $status): void
    {
        $pump
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($pump->getCreateBy())
        ;
    }

    /**
     * @param Pump $pump
     * @param bool $status
     */
    public function validate(Pump $pump, bool $status): void
    {
        $pump
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($pump->getCreateBy())
        ;
    }
}
