<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ProductFamilyRepository
 * @package App\Adapter\Doctrine\Repository
 */
class ProductFamilyRepository extends ServiceEntityRepository implements ProductFamilyGateway
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductFamily::class);
    }

    public function findOneById(int $id): ?ProductFamily
    {
        return parent::find(["id" => $id]);
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function create(ProductFamily $productfamily): void
    {
        $this->_em->persist($productfamily);
        $this->_em->flush();
    }

    public function update(ProductFamily $productfamily): void
    {
        $this->_em->persist($productfamily);
        $this->_em->flush();
    }

    public function activate(ProductFamily $productfamily, bool $status): void
    {
        $this->_em->persist($productfamily);
        $this->_em->flush();
    }

    public function validate(ProductFamily $productfamily, bool $status): void
    {
        $this->_em->persist($productfamily);
        $this->_em->flush();
    }
}
