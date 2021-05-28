<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Image;
use App\Form\ImageType;
use App\Gateway\ImageGateway;

/**
 * Class ImageRepository
 * @package App\Adapter\InMemory\Repository
 */
class ImageRepository implements ImageGateway
{
    /**
     * @var array
     */
    public array $image = [];

    /**
     * ImageRepository constructor.
     */
    public function __construct()
    {
        $entity = (new Image())
        ;

        $reflectionClass = new \ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->image[1] = $entity;
    }

    /**
     * @param int $id
     * @return Image|null
     */
    public function findOneById(int $id): ?Image
    {
        if (!array_key_exists($id, $this->image)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->image[$id];
    }

    /**
     * @return Image[]|null
     */
    public function findAll(): ?array
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function create(Image $image): void
    {
    }

    public function delete(Image $image): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return ImageType::class;
    }

    /**
     * @param Image $image
     */
    public function update(Image $image): void
    {
    }
}
