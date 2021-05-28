<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Image;
use App\Form\ImageType;
use App\Gateway\ImageGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * Class ImageRepository
 * @package App\Adapter\Doctrine\Repository
 */
class ImageRepository extends ServiceEntityRepository implements ImageGateway
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Image::class);
    }

    public function findOneById(int $id): ?Image
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
        return ImageType::class;
    }

    public function create(Image $image): void
    {
        $this->_em->persist($image);
        $this->_em->flush();
    }

    public function delete(Image $image): void
    {
        $this->_em->remove($image);
        $this->_em->flush();
    }

    public function update(Image $image): void
    {
        $this->_em->persist($image);
        $this->_em->flush();
    }
}
