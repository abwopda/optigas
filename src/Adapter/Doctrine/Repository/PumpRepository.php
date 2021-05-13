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

    public function findOneById(int $id): Pump
    {
        return parent::find(["id" => $id]);
    }

    public function create(Pump $pump): void
    {
        $this->_em->persist($pump);
        $this->_em->flush();
    }
}