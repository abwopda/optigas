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
     * @param Product $product
     * @return Product
     */
    public function execute(int $product): Product
    {
        $entity = $this->productGateway->findOneById($product);

        $this->productGateway->update($entity);
        return $entity;
    }
}
