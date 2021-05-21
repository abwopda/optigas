<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function create(TypeProduct $typeproduct): void
    {
        $user =  $this->security->getUser();

        $typeproduct->setCreateBy($user);
        $this->_em->persist($typeproduct);
        $this->_em->flush();
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
