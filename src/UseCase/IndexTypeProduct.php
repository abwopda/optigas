<?php

namespace App\UseCase;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Assert\Assert;

/**
 * Class IndexTypeProduct
 * @package App\UseCase
 */
class IndexTypeProduct
{
    /**
     * @var TypeProductGateway
     */
    private TypeProductGateway $typeproductGateway;

    /**
     * IndexTypeProduct constructor.
     * @param TypeProductGateway $typeproductGateway
     */
    public function __construct(TypeProductGateway $typeproductGateway)
    {
        $this->typeproductGateway = $typeproductGateway;
    }


    /**
     * @return TypeProduct[]|null
     */
    public function execute(): ?array
    {
        return $this->typeproductGateway->findAll();
    }
}
