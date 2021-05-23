<?php

namespace App\Gateway;

use App\Entity\ProductFamily;

/**
 * Interface ProductFamilyGateway
 * @package App\Gateway
 */
interface ProductFamilyGateway
{
    /**
     * @param ProductFamily $productfamily
     */
    public function create(ProductFamily $productfamily): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param int $id
     * @return ProductFamily|null
     */
    public function findOneById(int $id): ?ProductFamily;

    /**
     * @return ProductFamily[]|null
     */
    public function findAll(): ?array;

    /**
     * @param ProductFamily $productfamily
     */
    public function update(ProductFamily $productfamily): void;

    /**
     * @param ProductFamily $productfamily
     * @param bool $status
     */
    public function activate(ProductFamily $productfamily, bool $status): void;

    /**
     * @param ProductFamily $productfamily
     * @param bool $status
     */
    public function validate(ProductFamily $productfamily, bool $status): void;
}
