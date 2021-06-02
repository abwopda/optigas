<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;
use Assert\Assert;

/**
 * Class UseProductFamily
 * @package App\UseCase
 */
class UseProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * UseProductFamily constructor.
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(
        ProductFamilyGateway $productfamilyGateway
    ) {
        $this->productfamilyGateway = $productfamilyGateway;
    }

    /**
     * @param ProductFamily $productfamily
     * @return ProductFamily
     */
    public function create(ProductFamily $productfamily): ProductFamily
    {
        Assert::lazy()
            ->that($productfamily->getCode(), "code")->notBlank()
            ->that($productfamily->getName(), "name")->notBlank()
            ->that($productfamily->getDescription(), "description")->notBlank()
            ->verifyNow()
        ;

        $this->productfamilyGateway->create($productfamily);
        return $productfamily;
    }

    /**
     * @param ProductFamily $productfamily
     * @return ProductFamily|null
     */
    public function show(?ProductFamily $productfamily): ?ProductFamily
    {
        return $productfamily;
    }

    /**
     * @return ProductFamily[]|null
     */
    public function findAll(): ?array
    {
        return $this->productfamilyGateway->findAll();
    }

    /**
     * @param ProductFamily|null $productfamily
     * @return ProductFamily|null
     */
    public function update(?ProductFamily $productfamily): ?ProductFamily
    {
        $this->productfamilyGateway->update($productfamily);
        return $productfamily;
    }

    /**
     * @param ProductFamily|null $productfamily
     * @param bool $status
     * @return ProductFamily|null
     */
    public function activate(?ProductFamily $productfamily, bool $status): ?ProductFamily
    {
        $this->productfamilyGateway->activate($productfamily, $status);

        return $productfamily;
    }

    /**
     * @param ProductFamily|null $productfamily
     * @param bool $status
     * @return ProductFamily|null
     */
    public function validate(?ProductFamily $productfamily, bool $status): ?ProductFamily
    {
        $this->productfamilyGateway->validate($productfamily, $status);

        return $productfamily;
    }

    /**
     * @param ProductFamily|null $productfamily
     */
    public function delete(?ProductFamily $productfamily)
    {
        $this->productfamilyGateway->remove($productfamily);
    }
}
