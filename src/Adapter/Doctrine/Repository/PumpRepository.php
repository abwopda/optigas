<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Pump;
use App\Gateway\PumpGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PumpRepository
 * @package App\Adapter\Doctrine\Repository
 */
class PumpRepository extends ServiceEntityRepository implements PumpGateway
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pump::class);
    }

    public function findOneById(int $id): ?Pump
    {
        return parent::find(["id" => $id]);
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function create(Pump $pump): void
    {
        $this->_em->persist($pump);
        $this->_em->flush();
    }
    public function update(Pump $pump): void
    {
        $this->_em->persist($pump);
        $this->_em->flush();
    }

    public function activate(Pump $pump, bool $status): void
    {
        $this->_em->persist($pump);
        $this->_em->flush();
    }

    public function validate(Pump $pump, bool $status): void
    {
        $this->_em->persist($pump);
        $this->_em->flush();
    }
}
