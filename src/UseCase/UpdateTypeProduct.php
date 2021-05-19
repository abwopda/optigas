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
     * @param TypeProduct $typeproduct
     * @return TypeProduct
     */
    public function execute(int $typeproduct): TypeProduct
    {
        $entity = $this->typeproductGateway->findOneById($typeproduct);

        $this->typeproductGateway->update($entity);
        return $entity;
    }
}
