<?php

namespace App\UseCase;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Assert\Assert;

/**
 * Class ActivateTypeProduct
 * @package App\UseCase
 */
class ActivateTypeProduct
{
    /**
     * @var TypeProductGateway
     */
    private TypeProductGateway $typeproductGateway;

    /**
     * ActivateTypeProduct constructor.
     * @param TypeProductGateway $typeproductGateway
     */
    public function __construct(TypeProductGateway $typeproductGateway)
    {
        $this->typeproductGateway = $typeproductGateway;
    }

    /**
     * @param TypeProduct|null $typeproduct
     * @param bool $status
     * @return TypeProduct|null
     */
    public function execute(?TypeProduct $typeproduct, bool $status): ?TypeProduct
    {
        $this->typeproductGateway->activate($typeproduct, $status);

        return $typeproduct;
    }
}
