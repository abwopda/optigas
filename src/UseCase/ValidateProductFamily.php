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
     * @param ProductFamily $productfamily
     * @return ProductFamily
     */
    public function execute(int $productfamily, bool $status): ProductFamily
    {
        $entity = $this->productfamilyGateway->findOneById($productfamily);

        $this->productfamilyGateway->validate($entity, $status);

        return $entity;
    }
}
