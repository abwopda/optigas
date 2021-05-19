<?php

namespace App\Gateway;

use App\Entity\Product;

/**
 * Interface ProductGateway
 * @package App\Gateway
 */
interface ProductGateway
{
    /**
     * @param Product $product
     */
    public function create(Product $product): void;

    /**
     * @param int $id
     * @return Product|null
     */
    public function findOneById(int $id): ?Product;

    /**
     * @return Product[]|null
     */
    public function findAll(): ?array;

    /**
     * @param Product $product
     */
    public function update(Product $product): void;

    /**
     * @param Product $product
     * @param bool $status
     */
    public function activate(Product $product, bool $status): void;

    /**
     * @param Product $product
     * @param bool $status
     */
    public function validate(Product $product, bool $status): void;
}
