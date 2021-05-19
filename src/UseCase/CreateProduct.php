<?php

namespace App\UseCase;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Assert\Assert;

/**
 * Class CreateProduct
 * @package App\UseCase
 */
class CreateProduct
{
    /**
     * @var ProductGateway
     */
    private ProductGateway $productGateway;

    /**
     * CreateProduct constructor.
     * @param ProductGateway $productGateway
     */
    public function __construct(
        ProductGateway $productGateway
    ) {
        $this->productGateway = $productGateway;
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function execute(Product $product): Product
    {
        Assert::lazy()
            ->that($product->getCode(), "code")->notBlank()
            ->that($product->getName(), "name")->notBlank()
            ->that($product->getDescription(), "description")->notBlank()
            ->verifyNow()
        ;

        $this->productGateway->create($product);
        return $product;
    }
}
