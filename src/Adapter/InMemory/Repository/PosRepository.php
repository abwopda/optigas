<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Entity\Pos;
use App\Form\InMemory\PosType;
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
        $entity = (new Pos())
            ->setCode("01")
            ->setName("TAWAAL OIL AKAK")
            ->setDescription("Station Service")
            ->setTown("Yaounde")
            ->setAddress("BP 12570")
            ->setCapacity(90000)
            ->setCreateBy($employee)

        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->pos[1] = $entity;

        $entity = (new Pos())
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

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 2);

        $this->pos[2] =  $entity;

        $entity = (new Pos())
            ->setCode("03")
            ->setName("TAWAAL OIL NGOYA 1")
            ->setDescription("Station Service")
            ->setTown("Ngoya")
            ->setAddress("BP YYYY")
            ->setCapacity(70000)
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

        $this->pos[3] =  $entity;

        $entity = (new Pos())
            ->setCode("04")
            ->setName("TAWAAL OIL KRIBI")
            ->setDescription("Station Service")
            ->setTown("Kribi")
            ->setAddress("BP YYYY")
            ->setCapacity(53000)
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

        $this->pos[4] =  $entity;
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
     * @return Pos[]|null
     */
    public function findAll(): ?array
    {
        return $this->pos;
    }

    public function search($searchParam)
    {
        extract($searchParam);
        $data = $this->pos;
        $i = 1;
        if (!empty($ids)) {
            $poss = [];
            $i = 1;
            foreach ($data as $p) {
                if ($ids->contains($p)) {
                    $poss[$i++] = $p;
                }
            }
            $data = $poss;
        }

        if (!empty($keyword)) {
            //var_export($keyword);die;
            $poss = [];
            $i = 1;
            foreach ($data as $p) {
                //var_export(stripos($p->getName(),$keyword));
                if (stripos($p->getName(), $keyword) !== false or stripos($p->getDescription(), $keyword) !== false) {
                    $poss[$i++] = $p;
                }
            }
            //die;
            $data = $poss;
        }

        if (!empty($active)) {
            //var_export($active);die;
            if (in_array("0", $active)) {
                $poss = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getActive()) {
                        $poss[$i++] = $p;
                    }
                }
                $data = $poss;
            } else {
                $poss = [];
                $i = 1;
                foreach ($data as $p) {
                    if ($p->getActive()) {
                        $poss[$i++] = $p;
                    }
                }
                $data = $poss;
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $poss = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getValid()) {
                        $poss[$i++] = $p;
                    }
                }
                $data = $poss;
            } else {
                $poss = [];
                $i = 1;
                foreach ($data as $p) {
                    if (!$p->getValid()) {
                        $poss[$i++] = $p;
                    }
                }
                $data = $poss;
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
        return count($this->pos);
    }

    /**
     * @param Pos $pos
     */
    public function create(Pos $pos): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return PosType::class;
    }

    /**
     * @param Pos $pos
     */
    public function update(Pos $pos): void
    {
    }

    /**
     * @param Pos $pos
     */
    public function remove(Pos $pos): void
    {
    }

    /**
     * @param Pos $pos
     * @param bool $status
     */
    public function activate(Pos $pos, bool $status): void
    {
        $pos
            ->setActive($status)
            ->setActivateAt(new \DateTimeImmutable())
            ->setActivateBy($pos->getCreateBy())
        ;
    }

    /**
     * @param Pos $pos
     * @param bool $status
     */
    public function validate(Pos $pos, bool $status): void
    {
        $pos
            ->setValid($status)
            ->setValidateAt(new \DateTimeImmutable())
            ->setValidateBy($this->pos[1]->getCreateBy())
        ;
    }
}
