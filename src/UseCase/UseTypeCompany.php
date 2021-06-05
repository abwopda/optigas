<?php

namespace App\UseCase;

use App\Entity\TypeCompany;
use App\Gateway\TypeCompanyGateway;
use Assert\Assert;

/**
 * Class UseTypeCompany
 * @package App\UseCase
 */
class UseTypeCompany
{
    /**
     * @var TypeCompanyGateway
     */
    private TypeCompanyGateway $typecompanyGateway;

    /**
     * UseTypeCompany constructor.
     * @param TypeCompanyGateway $typecompanyGateway
     */
    public function __construct(TypeCompanyGateway $typecompanyGateway)
    {
        $this->typecompanyGateway = $typecompanyGateway;
    }


    /**
     * @param TypeCompany $typecompany
     * @return TypeCompany
     */
    public function create(TypeCompany $typecompany): TypeCompany
    {
        //var_export($typecompany);
        Assert::lazy()
            ->that($typecompany->getCode(), "code")->notBlank()
            ->that($typecompany->getName(), "name")->notBlank()
            ->that($typecompany->getDescription(), "description")->notBlank()
            ->verifyNow()
        ;

        $this->typecompanyGateway->create($typecompany);
        return $typecompany;
    }

    /**
     * @param TypeCompany $typecompany
     * @return TypeCompany|null
     */
    public function show(?TypeCompany $typecompany): ?TypeCompany
    {
        return $typecompany;
    }

    /**
     * @return TypeCompany[]|null
     */
    public function findAll(): ?array
    {
        return $this->typecompanyGateway->findAll();
    }

    /**
     * @param TypeCompany|null $typecompany
     * @return TypeCompany|null
     */
    public function update(?TypeCompany $typecompany): ?TypeCompany
    {
        $this->typecompanyGateway->update($typecompany);
        return $typecompany;
    }

    /**
     * @param TypeCompany|null $typecompany
     * @param bool $status
     * @return TypeCompany|null
     */
    public function activate(?TypeCompany $typecompany, bool $status): ?TypeCompany
    {
        $this->typecompanyGateway->activate($typecompany, $status);

        return $typecompany;
    }

    /**
     * @param TypeCompany|null $typecompany
     * @param bool $status
     * @return TypeCompany|null
     */
    public function validate(?TypeCompany $typecompany, bool $status): ?TypeCompany
    {
        $this->typecompanyGateway->validate($typecompany, $status);

        return $typecompany;
    }

    /**
     * @param TypeCompany|null $typecompany
     */
    public function delete(?TypeCompany $typecompany)
    {
        $this->typecompanyGateway->remove($typecompany);
    }
}
