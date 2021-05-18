<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PosRepository
 * @package App\Adapter\Doctrine\Repository
 */
class PosRepository extends ServiceEntityRepository implements PosGateway
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pos::class);
    }

    public function findOneById(int $id): Pos
    {
        return parent::find(["id" => $id]);
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function create(Pos $pos): void
    {
        $this->_em->persist($pos);
        $this->_em->flush();
    }

    public function update(Pos $pos): void
    {
        $this->_em->persist($pos);
        $this->_em->flush();
    }

    public function activate(Pos $pos, bool $status): void
    {
        $this->_em->persist($pos);
        $this->_em->flush();
    }

    public function validate(Pos $pos, bool $status): void
    {
        $this->_em->persist($pos);
        $this->_em->flush();
    }
}
