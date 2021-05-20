<?php

namespace App\UseCase;

use App\Entity\Product;
use App\Gateway\ProductGateway;

/**
 * Class UpdateProduct
 * @package App\UseCase
 */
class UpdateProduct
{
    /**
     * @var ProductGateway
     */
    private ProductGateway $productGateway;

    /**
     * UpdateProduct constructor.
     * @param ProductGateway $productGateway
     */
    public function __construct(ProductGateway $productGateway)
    {
        $this->productGateway = $productGateway;
    }
  
    /**
     * @param Product|null $product
     * @return Product|null
     */
    public function execute(?Product $product): ?Product
    {
        $this->productGateway->update($product);
        return $product;
    }
}
