<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\TypeProduct;
use App\Form\Doctrine\TypeProductType;
use App\Gateway\TypeProductGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class TypeProductRepository
 * @package App\Adapter\Doctrine\Repository
 */
class TypeProductRepository extends ServiceEntityRepository implements TypeProductGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, TypeProduct::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?TypeProduct
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
        $qb = parent::createQueryBuilder('t');

        if (!empty($ids)) {
            $qb->andWhere('t.id in (:ids)')->setParameter('ids', $ids);
        }

        if (!empty($keyword)) {
            $qb->andWhere('t.name like :keyword or t.description like :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        if (!empty($active)) {
            if (in_array("0", $active)) {
                $qb->andWhere('t.active is null or t.active in (:active)')->setParameter('active', $active);
            } else {
                $qb->andWhere('t.active in (:active)')->setParameter('active', $active);
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $qb->andWhere('t.valid is null or t.valid in (:valid)')->setParameter('valid', $valid);
            } else {
                $qb->andWhere('t.valid in (:valid)')->setParameter('valid', $valid);
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
        $qb = parent::createQueryBuilder('t')->select('COUNT(t)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function create(TypeProduct $typeproduct): void
    {
        $user =  $this->security->getUser();

        $typeproduct->setCreateBy($user);
        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return TypeProductType::class;
    }

    public function update(TypeProduct $typeproduct): void
    {
        $user =  $this->security->getUser();

        $typeproduct
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }

    public function remove(TypeProduct $typeProduct): void
    {
        $this->_em->remove($typeProduct);
        $this->_em->flush();
    }

    public function activate(TypeProduct $typeproduct, bool $status): void
    {
        $typeproduct->setActive($status);
        $user =  $this->security->getUser();
        $typeproduct->setActivateBy($user);
        $typeproduct->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }

    public function validate(TypeProduct $typeproduct, bool $status): void
    {
        $typeproduct->setValid($status);
        $user =  $this->security->getUser();
        $typeproduct->setValidateBy($user);
        $typeproduct->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($typeproduct);
        $this->_em->flush();
    }
}
