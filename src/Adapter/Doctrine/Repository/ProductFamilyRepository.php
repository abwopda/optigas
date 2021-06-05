<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\ProductFamily;
use App\Form\Doctrine\ProductFamilyType;
use App\Gateway\ProductFamilyGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class ProductFamilyRepository
 * @package App\Adapter\Doctrine\Repository
 */
class ProductFamilyRepository extends ServiceEntityRepository implements ProductFamilyGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, ProductFamily::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?ProductFamily
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
        $qb = parent::createQueryBuilder('f')
            ->leftJoin('f.typeproduct', 't');

        if (!empty($entity)) {
            if ($entity === "typeproduct") {
                if (!empty($id)) {
                                $qb->Where('t.id= :id')->setParameter('id', $id);
                }
            }
        }

        if (!empty($ids)) {
            $qb->andWhere('f.id in (:ids)')->setParameter('ids', $ids);
        }

        if (!empty($keyword)) {
            $qb->andWhere('f.name like :keyword or f.description like :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        if (!empty($active)) {
            if (in_array("0", $active)) {
                $qb->andWhere('f.active is null or f.active in (:active)')->setParameter('active', $active);
            } else {
                $qb->andWhere('f.active in (:active)')->setParameter('active', $active);
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $qb->andWhere('f.valid is null or f.valid in (:valid)')->setParameter('valid', $valid);
            } else {
                $qb->andWhere('f.valid in (:valid)')->setParameter('valid', $valid);
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

    public function create(ProductFamily $productfamily): void
    {
        $user =  $this->security->getUser();

        $productfamily->setCreateBy($user);
        $this->_em->persist($productfamily);
        $this->_em->flush();
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return ProductFamilyType::class;
    }

    public function update(ProductFamily $productfamily): void
    {
        $user =  $this->security->getUser();

        $productfamily
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($productfamily);
        $this->_em->flush();
    }

    public function remove(ProductFamily $productFamily): void
    {
        $this->_em->remove($productFamily);
        $this->_em->flush();
    }

    public function activate(ProductFamily $productfamily, bool $status): void
    {
        $productfamily->setActive($status);
        $user =  $this->security->getUser();
        $productfamily->setActivateBy($user);
        $productfamily->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($productfamily);
        $this->_em->flush();
    }

    public function validate(ProductFamily $productfamily, bool $status): void
    {
        $productfamily->setValid($status);
        $user =  $this->security->getUser();
        $productfamily->setValidateBy($user);
        $productfamily->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($productfamily);
        $this->_em->flush();
    }
}
