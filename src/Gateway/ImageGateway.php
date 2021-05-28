<?php

namespace App\Gateway;

use App\Entity\Image;

/**
 * Interface ImageGateway
 * @package App\Gateway
 */
interface ImageGateway
{
    /**
     * @param Image $image
     */
    public function create(Image $image): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param Image $image
     */
    public function update(Image $image): void;


    /**
     * @param int $id
     * @return Image|null
     */
    public function findOneById(int $id): ?Image;

    /**
     * @return Image[]|null
     */
    public function findAll(): ?array;
}
