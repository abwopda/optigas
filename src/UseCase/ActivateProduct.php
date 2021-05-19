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
     * @param Product $product
     * @return Product
     */
    public function execute(int $product, bool $status): Product
    {
        $entity = $this->productGateway->findOneById($product);

        $this->productGateway->activate($entity, $status);

        return $entity;
    }
}
