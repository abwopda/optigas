<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ProductRepository
 * @package App\Adapter\Doctrine\Repository
 */
class ProductRepository extends ServiceEntityRepository implements ProductGateway
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    public function findOneById(int $id): ?Product
    {
        return parent::find(["id" => $id]);
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function create(Product $product): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function update(Product $product): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function activate(Product $product, bool $status): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function validate(Product $product, bool $status): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }
}
