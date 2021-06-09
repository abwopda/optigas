<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Store;
use App\Form\Doctrine\StoreType;
use App\Gateway\StoreGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class StoreRepository
 * @package App\Adapter\Doctrine\Repository
 */
class StoreRepository extends ServiceEntityRepository implements StoreGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, Store::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?Store
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
        $qb = parent::createQueryBuilder('s');

        if (!empty($ids)) {
            $qb->andWhere('s.id in (:ids)')->setParameter('ids', $ids);
        }

        if (!empty($keyword)) {
            $qb->andWhere('s.name like :keyword or s.description like :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        if (!empty($active)) {
            if (in_array("0", $active)) {
                $qb->andWhere('s.active is null or s.active in (:active)')->setParameter('active', $active);
            } else {
                $qb->andWhere('s.active in (:active)')->setParameter('active', $active);
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $qb->andWhere('s.valid is null or s.valid in (:valid)')->setParameter('valid', $valid);
            } else {
                $qb->andWhere('s.valid in (:valid)')->setParameter('valid', $valid);
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
        $qb = parent::createQueryBuilder('s')->select('COUNT(s)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return StoreType::class;
    }

    public function create(Store $store): void
    {
        $user =  $this->security->getUser();

        $store->setCreateBy($user);
        $this->_em->persist($store);
        $this->_em->flush();
    }

    public function update(Store $store): void
    {
        $user =  $this->security->getUser();

        $store
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($store);
        $this->_em->flush();
    }

    public function remove(Store $store): void
    {
        $this->_em->remove($store);
        $this->_em->flush();
    }

    public function activate(Store $store, bool $status): void
    {
        $store->setActive($status);
        $user =  $this->security->getUser();
        $store->setActivateBy($user);
        $store->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($store);
        $this->_em->flush();
    }

    public function validate(Store $store, bool $status): void
    {
        $store->setValid($status);
        $user =  $this->security->getUser();
        $store->setValidateBy($user);
        $store->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($store);
        $this->_em->flush();
    }
}
