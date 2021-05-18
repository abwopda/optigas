<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TankRepository
 * @package App\Adapter\Doctrine\Repository
 */
class TankRepository extends ServiceEntityRepository implements TankGateway
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tank::class);
    }

    public function findOneById(int $id): Tank
    {
        return parent::find(["id" => $id]);
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function create(Tank $tank): void
    {
        $this->_em->persist($tank);
        $this->_em->flush();
    }

    public function update(Tank $tank): void
    {
        $this->_em->persist($tank);
        $this->_em->flush();
    }

    public function activate(Tank $tank, bool $status): void
    {
        $this->_em->persist($tank);
        $this->_em->flush();
    }
    public function validate(Tank $tank, bool $status): void
    {
        $this->_em->persist($tank);
        $this->_em->flush();
    }
}
