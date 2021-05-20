<?php

namespace App\UseCase;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Assert\Assert;

/**
 * Class IndexProduct
 * @package App\UseCase
 */
class IndexProduct
{
    /**
     * @var ProductGateway
     */
    private ProductGateway $productGateway;

    /**
     * IndexProduct constructor.
     * @param ProductGateway $productGateway
     */
    public function __construct(ProductGateway $productGateway)
    {
        $this->productGateway = $productGateway;
    }


    /**
     * @return Product[]|null
     */
    public function execute(): ?array
    {
        return $this->productGateway->findAll();
    }
}
