<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;
use Assert\Assert;

/**
 * Class IndexProductFamily
 * @package App\UseCase
 */
class IndexProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * IndexProductFamily constructor.
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(ProductFamilyGateway $productfamilyGateway)
    {
        $this->productfamilyGateway = $productfamilyGateway;
    }


    /**
     * @return ProductFamily[]|null
     */
    public function execute(): ?array
    {
        return $this->productfamilyGateway->findAll();
    }
}
