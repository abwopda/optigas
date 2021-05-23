<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Pos;
use App\Form\Doctrine\PosType;
use App\Gateway\PosGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
