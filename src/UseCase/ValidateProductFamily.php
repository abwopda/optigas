<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;
use Assert\Assert;

/**
 * Class ValidateProductFamily
 * @package App\UseCase
 */
class ValidateProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * ValidateProductFamily constructor.
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(ProductFamilyGateway $productfamilyGateway)
    {
        $this->productfamilyGateway = $productfamilyGateway;
    }

    /**
     * @param ProductFamily|null $productfamily
     * @param bool $status
     * @return ProductFamily|null
     */
    public function execute(?ProductFamily $productfamily, bool $status): ?ProductFamily
    {
        $this->productfamilyGateway->validate($productfamily, $status);

        return $productfamily;
    }
}
