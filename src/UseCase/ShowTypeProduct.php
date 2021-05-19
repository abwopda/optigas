<?php

namespace App\UseCase;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Assert\Assert;

/**
 * Class ShowTypeProduct
 * @package App\UseCase
 */
class ShowTypeProduct
{
    /**
     * @var TypeProductGateway
     */
    private TypeProductGateway $typeproductGateway;

    /**
     * ShowTypeProduct constructor.
     * @param TypeProductGateway $typeproductGateway
     */
    public function __construct(TypeProductGateway $typeproductGateway)
    {
        $this->typeproductGateway = $typeproductGateway;
    }


    /**
     * @param TypeProduct $typeproduct
     * @return TypeProduct|null
     */
    public function execute(int $typeproduct): ?TypeProduct
    {
        return $this->typeproductGateway->findOneById($typeproduct);
    }
}
