<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Pump;
use App\Form\Doctrine\PumpType;
use App\Gateway\PumpGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class PumpRepository
 * @package App\Adapter\Doctrine\Repository
 */
class PumpRepository extends ServiceEntityRepository implements PumpGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, Pump::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?Pump
    {
        return parent::find(["id" => $id]);
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function search($searchParam)
    {
        //die(json_encode($searchParam));
        extract($searchParam);
        $qb = parent::createQueryBuilder('p')
            ->leftJoin('p.tank', 't')
            ->leftJoin('t.pos', 'pos');

        if (!empty($entity)) {
            if ($entity === "pos") {
                if (!empty($id)) {
                                $qb->Where('pos.id= :id')->setParameter('id', $id);
                }
            }
        }

        if (!empty($entity)) {
            if ($entity === "tank") {
                if (!empty($id)) {
                                $qb->Where('t.id= :id')->setParameter('id', $id);
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

    public function create(Pump $pump): void
    {
        $user =  $this->security->getUser();

        $pump->setCreateBy($user);
        $this->_em->persist($pump);
        $this->_em->flush();
    }


    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return PumpType::class;
    }

    public function update(Pump $pump): void
    {
        $user =  $this->security->getUser();

        $pump
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($pump);
        $this->_em->flush();
    }

    public function remove(Pump $pump): void
    {
        $this->_em->remove($pump);
        $this->_em->flush();
    }

    public function activate(Pump $pump, bool $status): void
    {
        $pump->setActive($status);
        $user =  $this->security->getUser();
        $pump->setActivateBy($user);
        $pump->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($pump);
        $this->_em->flush();
    }

    public function validate(Pump $pump, bool $status): void
    {
        $pump->setValid($status);
        $user =  $this->security->getUser();
        $pump->setValidateBy($user);
        $pump->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($pump);
        $this->_em->flush();
    }
}
