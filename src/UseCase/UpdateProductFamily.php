<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;

/**
 * Class UpdateProductFamily
 * @package App\UseCase
 */
class UpdateProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * UpdateProductFamily constructor.
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(ProductFamilyGateway $productfamilyGateway)
    {
        $this->productfamilyGateway = $productfamilyGateway;
    }

    /**
     * @param ProductFamily|null $productfamily
     * @return ProductFamily|null
     */
    public function execute(?ProductFamily $productfamily): ?ProductFamily
    {
        $this->productfamilyGateway->update($productfamily);
        return $productfamily;
    }
}
