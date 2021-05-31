<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Product;
use App\Form\Doctrine\ProductType;
use App\Gateway\ProductGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function search($searchParam)
    {
        extract($searchParam);
        $qb = parent::createQueryBuilder('p')
            ->leftJoin('p.productfamily', 'f')
            ->leftJoin('f.typeproduct', 't');

        if (!empty($entity)) {
            if ($entity === "typeproduct") {
                if (!empty($id)) {
                                $qb->Where('t.id= :id')->setParameter('id', $id);
                }
            }
        }

        if (!empty($entity)) {
            if ($entity === "productfamily") {
                if (!empty($id)) {
                                $qb->Where('f.id= :id')->setParameter('id', $id);
                }
            }
        }


        if (!empty($ids)) {
            $qb->andWhere('p.id in (:ids)')->setParameter('ids', $ids);
        }

        if (!empty($keyword)) {
            $qb->andWhere('p.name like :keyword or p.description like :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        if (!empty($active)) {
            if (in_array("0", $active)) {
                $qb->andWhere('p.active is null or p.active in (:active)')->setParameter('active', $active);
            } else {
                $qb->andWhere('p.active in (:active)')->setParameter('active', $active);
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $qb->andWhere('p.valid is null or p.valid in (:valid)')->setParameter('valid', $valid);
            } else {
                $qb->andWhere('p.valid in (:valid)')->setParameter('valid', $valid);
            }
        }


        $qb->getQuery();

        if (!empty($perPage)) {
            $qb->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);
        }


        return new Paginator($qb, true);
    }

    public function counter()
    {
        $qb = parent::createQueryBuilder('p')->select('COUNT(p)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function create(Product $product): void
    {
        $user =  $this->security->getUser();

        $product->setCreateBy($user);
        $this->_em->persist($product);
        $this->_em->flush();
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return ProductType::class;
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

    public function remove(Product $product): void
    {
        $this->_em->remove($product);
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
