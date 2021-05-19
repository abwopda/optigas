<?php

namespace App\UseCase;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Assert\Assert;

/**
 * Class ValidateProduct
 * @package App\UseCase
 */
class ValidateProduct
{
    /**
     * @var ProductGateway
     */
    private ProductGateway $productGateway;

    /**
     * ValidateProduct constructor.
     * @param ProductGateway $productGateway
     */
    public function __construct(ProductGateway $productGateway)
    {
        $this->productGateway = $productGateway;
    }


    /**
     * @param Product $product
     * @return Product
     */
    public function execute(int $product, bool $status): Product
    {
        $entity = $this->productGateway->findOneById($product);

        $this->productGateway->validate($entity, $status);

        return $entity;
    }
}
