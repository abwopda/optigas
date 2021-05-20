<?php

namespace App\UseCase;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Assert\Assert;

/**
 * Class ActivateProduct
 * @package App\UseCase
 */
class ActivateProduct
{
    /**
     * @var ProductGateway
     */
    private ProductGateway $productGateway;

    /**
     * ActivateProduct constructor.
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
        $this->productGateway->activate($product, $status);

        return $product;
    }
}
