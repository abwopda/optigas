<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Pos;
use App\Form\Doctrine\PosType;
use App\Gateway\PosGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class PosRepository
 * @package App\Adapter\Doctrine\Repository
 */
class PosRepository extends ServiceEntityRepository implements PosGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, Pos::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?Pos
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
        $qb = parent::createQueryBuilder('p');

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

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return PosType::class;
    }

    public function create(Pos $pos): void
    {
        $user =  $this->security->getUser();

        $pos->setCreateBy($user);
        $this->_em->persist($pos);
        $this->_em->flush();
    }

    public function update(Pos $pos): void
    {
        $user =  $this->security->getUser();

        $pos
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($pos);
        $this->_em->flush();
    }

    public function remove(Pos $pos): void
    {
        $this->_em->remove($pos);
        $this->_em->flush();
    }

    public function activate(Pos $pos, bool $status): void
    {
        $pos->setActive($status);
        $user =  $this->security->getUser();
        $pos->setActivateBy($user);
        $pos->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($pos);
        $this->_em->flush();
    }

    public function validate(Pos $pos, bool $status): void
    {
        $pos->setValid($status);
        $user =  $this->security->getUser();
        $pos->setValidateBy($user);
        $pos->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($pos);
        $this->_em->flush();
    }
}
