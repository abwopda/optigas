<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Config;
use App\Form\ConfigType;
use App\Gateway\ConfigGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ConfigRepository
 * @package App\Adapter\Doctrine\Repository
 */
class ConfigRepository extends ServiceEntityRepository implements ConfigGateway
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Config::class);
    }

    public function findOneById(int $id): ?Config
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
        return ConfigType::class;
    }

    public function create(Config $config): void
    {
        $this->_em->persist($config);
        $this->_em->flush();
    }

    public function update(Config $config): void
    {
        $this->_em->persist($config);
        $this->_em->flush();
    }

    public function delete(Config $config): void
    {
        $this->_em->remove($config);
        $this->_em->flush();
    }

    public function updateBy($key, $value): int
    {
        $qB = $this->_em->createQueryBuilder()
            ->update(Config::class, 'c')
            ->set('c.theValue', '?1')
            ->where('c.theKey = ?2')
            ->setParameter(1, $value)
            ->setParameter(2, $key);
        return $qB->getQuery()->execute();
    }
}
