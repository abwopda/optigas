<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Pump;
use App\Form\Doctrine\PumpType;
use App\Gateway\PumpGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
