<?php

namespace App\UseCase;

use App\Entity\ProductFamily;
use App\Gateway\ProductFamilyGateway;

/**
 * Class UpdateProductFamily
 * @package App\UseCase
 */
class UpdateProductFamily
{
    /**
     * @var ProductFamilyGateway
     */
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * UpdateProductFamily constructor.
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(ProductFamilyGateway $productfamilyGateway)
    {
        $this->productfamilyGateway = $productfamilyGateway;
    }


    /**
     * @param ProductFamily $productfamily
     * @return ProductFamily
     */
    public function execute(int $productfamily): ProductFamily
    {
        $entity = $this->productfamilyGateway->findOneById($productfamily);

        $this->productfamilyGateway->update($entity);
        return $entity;
    }
}
