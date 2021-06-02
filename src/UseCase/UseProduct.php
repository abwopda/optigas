<?php

namespace App\UseCase;

use App\Entity\Product;
use App\Gateway\ProductGateway;
use Assert\Assert;

/**
 * Class UseProduct
 * @package App\UseCase
 */
class UseProduct
{
    /**
     * @var ProductGateway
     */
    private ProductGateway $productGateway;

    /**
     * UseProduct constructor.
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
    public function create(Product $product): Product
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

    /**
     * @param Product $product
     * @return Product|null
     */
    public function show(?Product $product): ?Product
    {
        return $product;
    }

    /**
     * @return Product[]|null
     */
    public function findAll(): ?array
    {
        return $this->productGateway->findAll();
    }

    /**
     * @param Product|null $product
     * @return Product|null
     */
    public function update(?Product $product): ?Product
    {
        $this->productGateway->update($product);
        return $product;
    }

    /**
     * @param Product|null $product
     * @param bool $status
     * @return Product|null
     */
    public function activate(?Product $product, bool $status): ?Product
    {
        $this->productGateway->activate($product, $status);

        return $product;
    }

    /**
     * @param Product|null $product
     * @param bool $status
     * @return Product|null
     */
    public function validate(?Product $product, bool $status): ?Product
    {
        $this->productGateway->validate($product, $status);

        return $product;
    }

    /**
     * @param Product|null $product
     */
    public function delete(?Product $product)
    {
        $this->productGateway->remove($product);
    }
}
