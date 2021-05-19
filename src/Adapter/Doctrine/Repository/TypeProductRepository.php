<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TypeProductRepository
 * @package App\Adapter\Doctrine\Repository
 */
class TypeProductRepository extends ServiceEntityRepository implements TypeProductGateway
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeProduct::class);
    }

    public function findOneById(int $id): TypeProduct
    {
        return parent::find(["id" => $id]);
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function create(TypeProduct $typeproduct): void
    {
        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }

    public function update(TypeProduct $typeproduct): void
    {
        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }

    public function activate(TypeProduct $typeproduct, bool $status): void
    {
        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }

    public function validate(TypeProduct $typeproduct, bool $status): void
    {
        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }
}
