<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class ProductRepository
 * @package App\Adapter\Doctrine\Repository
 */
class ProductRepository extends ServiceEntityRepository implements ProductGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, Product::class);
        $this->security = $security;
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
        $user =  $this->security->getUser();

        $product->setCreateBy($user);
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function update(Product $product): void
    {
        $user =  $this->security->getUser();

        $product
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function activate(Product $product, bool $status): void
    {
        $product->setActive($status);
        $user =  $this->security->getUser();
        $product->setActivateBy($user);
        $product->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function validate(Product $product, bool $status): void
    {
        $product->setValid($status);
        $user =  $this->security->getUser();
        $product->setValidateBy($user);
        $product->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($product);
        $this->_em->flush();
    }
}
