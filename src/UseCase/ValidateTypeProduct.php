<?php

namespace App\UseCase;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Assert\Assert;

/**
 * Class ValidateTypeProduct
 * @package App\UseCase
 */
class ValidateTypeProduct
{
    /**
     * @var TypeProductGateway
     */
    private TypeProductGateway $typeproductGateway;

    /**
     * ValidateTypeProduct constructor.
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
        $this->typeproductGateway->validate($typeproduct, $status);

        return $typeproduct;
    }
}
