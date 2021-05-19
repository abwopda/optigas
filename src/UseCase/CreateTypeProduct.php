<?php

namespace App\UseCase;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Assert\Assert;

/**
 * Class CreateTypeProduct
 * @package App\UseCase
 */
class CreateTypeProduct
{
    /**
     * @var TypeProductGateway
     */
    private TypeProductGateway $typeproductGateway;

    /**
     * CreateTypeProduct constructor.
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
    public function execute(TypeProduct $typeproduct): TypeProduct
    {
        //var_export($typeproduct);
        Assert::lazy()
            ->that($typeproduct->getCode(), "code")->notBlank()
            ->that($typeproduct->getName(), "name")->notBlank()
            ->that($typeproduct->getDescription(), "description")->notBlank()
            ->verifyNow()
        ;

        $this->typeproductGateway->create($typeproduct);
        return $typeproduct;
    }
}
