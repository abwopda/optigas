<?php

namespace App\UseCase;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Assert\Assert;

/**
 * Class ShowProduct
 * @package App\UseCase
 */
class ShowProduct
{
    /**
     * @var ProductGateway
     */
    private ProductGateway $productGateway;

    /**
     * ShowProduct constructor.
     * @param ProductGateway $productGateway
     */
    public function __construct(ProductGateway $productGateway)
    {
        $this->productGateway = $productGateway;
    }


    /**
     * @param Product $product
     * @return Product|null
     */
    public function execute(int $product): ?Product
    {
        return $this->productGateway->findOneById($product);
    }
}
