<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;
use Assert\Assert;

/**
 * Class ShowProductFamily
 * @package App\UseCase
 */
class ShowProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * ShowProductFamily constructor.
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(ProductFamilyGateway $productfamilyGateway)
    {
        $this->productfamilyGateway = $productfamilyGateway;
    }


    /**
     * @param ProductFamily $productfamily
     * @return ProductFamily|null
     */
    public function execute(int $productfamily): ?ProductFamily
    {
        return $this->productfamilyGateway->findOneById($productfamily);
    }
}
