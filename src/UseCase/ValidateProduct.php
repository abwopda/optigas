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
     * @param Product|null $product
     * @param bool $status
     * @return Product|null
     */
    public function execute(?Product $product, bool $status): ?Product
    {
        $this->productGateway->validate($product, $status);

        return $product;
    }
}
