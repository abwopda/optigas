<?php

namespace App\UseCase;

use App\Entity\TypeProduct;
use App\Gateway\TypeProductGateway;
use Assert\Assert;

/**
 * Class UseTypeProduct
 * @package App\UseCase
 */
class UseTypeProduct
{
    /**
     * @var TypeProductGateway
     */
    private TypeProductGateway $typeproductGateway;

    /**
     * UseTypeProduct constructor.
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
    public function create(TypeProduct $typeproduct): TypeProduct
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

    /**
     * @param TypeProduct $typeproduct
     * @return TypeProduct|null
     */
    public function show(?TypeProduct $typeproduct): ?TypeProduct
    {
        return $typeproduct;
    }

    /**
     * @return TypeProduct[]|null
     */
    public function findAll(): ?array
    {
        return $this->typeproductGateway->findAll();
    }

    /**
     * @param TypeProduct|null $typeproduct
     * @return TypeProduct|null
     */
    public function update(?TypeProduct $typeproduct): ?TypeProduct
    {
        $this->typeproductGateway->update($typeproduct);
        return $typeproduct;
    }

    /**
     * @param TypeProduct|null $typeproduct
     * @param bool $status
     * @return TypeProduct|null
     */
    public function activate(?TypeProduct $typeproduct, bool $status): ?TypeProduct
    {
        $this->typeproductGateway->activate($typeproduct, $status);

        return $typeproduct;
    }

    /**
     * @param TypeProduct|null $typeproduct
     * @param bool $status
     * @return TypeProduct|null
     */
    public function validate(?TypeProduct $typeproduct, bool $status): ?TypeProduct
    {
        $this->typeproductGateway->validate($typeproduct, $status);

        return $typeproduct;
    }

    /**
     * @param TypeProduct|null $typeproduct
     */
    public function delete(?TypeProduct $typeproduct)
    {
        $this->typeproductGateway->remove($typeproduct);
    }
}
