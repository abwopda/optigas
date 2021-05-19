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
     * @param TypeProduct $typeproduct
     * @return TypeProduct
     */
    public function execute(int $typeproduct, bool $status): TypeProduct
    {
        $entity = $this->typeproductGateway->findOneById($typeproduct);

        $this->typeproductGateway->validate($entity, $status);

        return $entity;
    }
}
