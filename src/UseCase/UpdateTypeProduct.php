<?php

namespace App\UseCase;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Assert\Assert;

/**
 * Class UpdateTypeProduct
 * @package App\UseCase
 */
class UpdateTypeProduct
{
    /**
     * @var TypeProductGateway
     */
    private TypeProductGateway $typeproductGateway;

    /**
     * UpdateTypeProduct constructor.
     * @param TypeProductGateway $typeproductGateway
     */
    public function __construct(TypeProductGateway $typeproductGateway)
    {
        $this->typeproductGateway = $typeproductGateway;
    }

    /**
     * @param TypeProduct|null $typeproduct
     * @return TypeProduct|null
     */
    public function execute(?TypeProduct $typeproduct): ?TypeProduct
    {
        $this->typeproductGateway->update($typeproduct);
        return $typeproduct;
    }
}
