<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\TypeCompany;
use App\Form\Doctrine\TypeCompanyType;
use App\Gateway\TypeCompanyGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class TypeCompanyRepository
 * @package App\Adapter\Doctrine\Repository
 */
class TypeCompanyRepository extends ServiceEntityRepository implements TypeCompanyGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, TypeCompany::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?TypeCompany
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

    public function create(TypeCompany $typecompany): void
    {
        $user =  $this->security->getUser();

        $typecompany->setCreateBy($user);
        $this->_em->persist($typecompany);
        $this->_em->flush();
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return TypeCompanyType::class;
    }

    public function update(TypeCompany $typecompany): void
    {
        $user =  $this->security->getUser();

        $typecompany
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($typecompany);
        $this->_em->flush();
    }

    public function remove(TypeCompany $typeCompany): void
    {
        $this->_em->remove($typeCompany);
        $this->_em->flush();
    }

    public function activate(TypeCompany $typecompany, bool $status): void
    {
        $typecompany->setActive($status);
        $user =  $this->security->getUser();
        $typecompany->setActivateBy($user);
        $typecompany->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($typecompany);
        $this->_em->flush();
    }

    public function validate(TypeCompany $typecompany, bool $status): void
    {
        $typecompany->setValid($status);
        $user =  $this->security->getUser();
        $typecompany->setValidateBy($user);
        $typecompany->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($typecompany);
        $this->_em->flush();
    }
}
