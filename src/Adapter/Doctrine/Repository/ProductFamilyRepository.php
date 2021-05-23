<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\ProductFamily;
use App\Form\Doctrine\ProductFamilyType;
use App\Gateway\ProductFamilyGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
