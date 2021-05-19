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
     * @param TypeProduct $typeproduct
     * @return TypeProduct
     */
    public function execute(int $typeproduct, bool $status): TypeProduct
    {
        $entity = $this->typeproductGateway->findOneById($typeproduct);

        $this->typeproductGateway->activate($entity, $status);

        return $entity;
    }
}
