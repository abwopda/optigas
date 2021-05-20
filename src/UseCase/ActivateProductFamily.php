<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;
use Assert\Assert;

/**
 * Class ActivateProductFamily
 * @package App\UseCase
 */
class ActivateProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * ActivateProductFamily constructor.
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
        $this->productfamilyGateway->activate($productfamily, $status);

        return $productfamily;
    }
}
