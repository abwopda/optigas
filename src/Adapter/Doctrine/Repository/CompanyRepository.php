<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Company;
use App\Form\Doctrine\CompanyType;
use App\Gateway\CompanyGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class CompanyRepository
 * @package App\Adapter\Doctrine\Repository
 */
class CompanyRepository extends ServiceEntityRepository implements CompanyGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, Company::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?Company
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
        $qb = parent::createQueryBuilder('c')
            ->leftJoin('c.families', 'f')
            ->leftJoin('f.typecompany', 't');

        if (!empty($entity)) {
            if ($entity === "typecompany") {
                if (!empty($id)) {
                                $qb->Where('t.id= :id')->setParameter('id', $id);
                }
            }
        }

        if (!empty($entity)) {
            if ($entity === "companyfamily") {
                if (!empty($id)) {
                                $qb->Where(':id member of f')->setParameter('id', $id);
                }
            }
        }

        if (!empty($ids)) {
            $qb->andWhere('c.id in (:ids)')->setParameter('ids', $ids);
        }

        if (!empty($keyword)) {
            $qb->andWhere('c.name like :keyword or c.description like :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        if (!empty($active)) {
            if (in_array("0", $active)) {
                $qb->andWhere('c.active is null or c.active in (:active)')->setParameter('active', $active);
            } else {
                $qb->andWhere('c.active in (:active)')->setParameter('active', $active);
            }
        }

        if (!empty($valid)) {
            if (in_array("0", $valid)) {
                $qb->andWhere('c.valid is null or c.valid in (:valid)')->setParameter('valid', $valid);
            } else {
                $qb->andWhere('c.valid in (:valid)')->setParameter('valid', $valid);
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

    public function create(Company $company): void
    {
        $user =  $this->security->getUser();

        $company->setCreateBy($user);
        $this->_em->persist($company);
        $this->_em->flush();
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return CompanyType::class;
    }

    public function update(Company $company): void
    {
        $user =  $this->security->getUser();

        $company
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($company);
        $this->_em->flush();
    }

    public function remove(Company $company): void
    {
        $this->_em->remove($company);
        $this->_em->flush();
    }

    public function activate(Company $company, bool $status): void
    {
        $company->setActive($status);
        $user =  $this->security->getUser();
        $company->setActivateBy($user);
        $company->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($company);
        $this->_em->flush();
    }

    public function validate(Company $company, bool $status): void
    {
        $company->setValid($status);
        $user =  $this->security->getUser();
        $company->setValidateBy($user);
        $company->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($company);
        $this->_em->flush();
    }
}
