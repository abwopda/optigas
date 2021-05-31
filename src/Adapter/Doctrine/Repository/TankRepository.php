<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Tank;
use App\Form\Doctrine\TankType;
use App\Gateway\TankGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class TankRepository
 * @package App\Adapter\Doctrine\Repository
 */
class TankRepository extends ServiceEntityRepository implements TankGateway
{

    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, Tank::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?Tank
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
        $qb = parent::createQueryBuilder('t')
            ->leftJoin('t.pos', 'p');

        if (!empty($entity)) {
            if ($entity === "pos") {
                if (!empty($id)) {
                                $qb->Where('p.id= :id')->setParameter('id', $id);
                }
            }
        }

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

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return TankType::class;
    }

    public function create(Tank $tank): void
    {
        $user =  $this->security->getUser();

        $tank->setCreateBy($user);
        $this->_em->persist($tank);
        $this->_em->flush();
    }

    public function update(Tank $tank): void
    {
        $user =  $this->security->getUser();

        $tank
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($tank);
        $this->_em->flush();
    }

    public function remove(Tank $tank): void
    {
        $this->_em->remove($tank);
        $this->_em->flush();
    }

    public function activate(Tank $tank, bool $status): void
    {
        $tank->setActive($status);
        $user =  $this->security->getUser();
        $tank->setActivateBy($user);
        $tank->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($tank);
        $this->_em->flush();
    }

    public function validate(Tank $tank, bool $status): void
    {
        $tank->setValid($status);
        $user =  $this->security->getUser();
        $tank->setValidateBy($user);
        $tank->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($tank);
        $this->_em->flush();
    }
}
