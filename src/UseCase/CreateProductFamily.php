<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;
use Assert\Assert;

/**
 * Class CreateProductFamily
 * @package App\UseCase
 */
class CreateProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * CreateProductFamily constructor.
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(
        ProductFamilyGateway $productfamilyGateway
    ) {
        $this->productfamilyGateway = $productfamilyGateway;
    }

    /**
     * @param ProductFamily $productfamily
     * @return ProductFamily
     */
    public function execute(ProductFamily $productfamily): ProductFamily
    {
        Assert::lazy()
            ->that($productfamily->getCode(), "code")->notBlank()
            ->that($productfamily->getName(), "name")->notBlank()
            ->that($productfamily->getDescription(), "description")->notBlank()
            ->verifyNow()
        ;

        $this->productfamilyGateway->create($productfamily);
        return $productfamily;
    }
}
