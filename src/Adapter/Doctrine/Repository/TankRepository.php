<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
