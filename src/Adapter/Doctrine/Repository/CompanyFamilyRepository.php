<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\CompanyFamily;
use App\Form\Doctrine\CompanyFamilyType;
use App\Gateway\CompanyFamilyGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class CompanyFamilyRepository
 * @package App\Adapter\Doctrine\Repository
 */
class CompanyFamilyRepository extends ServiceEntityRepository implements CompanyFamilyGateway
{
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    ) {
        parent::__construct($registry, CompanyFamily::class);
        $this->security = $security;
    }

    public function findOneById(int $id): ?CompanyFamily
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
            ->leftJoin('f.typecompany', 't');

        if (!empty($entity)) {
            if ($entity === "typecompany") {
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

    public function create(CompanyFamily $companyfamily): void
    {
        $user =  $this->security->getUser();

        $companyfamily->setCreateBy($user);
        $this->_em->persist($companyfamily);
        $this->_em->flush();
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return CompanyFamilyType::class;
    }

    public function update(CompanyFamily $companyfamily): void
    {
        $user =  $this->security->getUser();

        $companyfamily
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;
        $this->_em->persist($companyfamily);
        $this->_em->flush();
    }

    public function remove(CompanyFamily $companyFamily): void
    {
        $this->_em->remove($companyFamily);
        $this->_em->flush();
    }

    public function activate(CompanyFamily $companyfamily, bool $status): void
    {
        $companyfamily->setActive($status);
        $user =  $this->security->getUser();
        $companyfamily->setActivateBy($user);
        $companyfamily->setActivateAt(new \DateTimeImmutable());

        $this->_em->persist($companyfamily);
        $this->_em->flush();
    }

    public function validate(CompanyFamily $companyfamily, bool $status): void
    {
        $companyfamily->setValid($status);
        $user =  $this->security->getUser();
        $companyfamily->setValidateBy($user);
        $companyfamily->setValidateAt(new \DateTimeImmutable());

        $this->_em->persist($companyfamily);
        $this->_em->flush();
    }
}
