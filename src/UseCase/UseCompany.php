<?php

namespace App\UseCase;

use App\Entity\Company;
use App\Gateway\CompanyGateway;
use Assert\Assert;

/**
 * Class UseCompany
 * @package App\UseCase
 */
class UseCompany
{
    /**
     * @var CompanyGateway
     */
    private CompanyGateway $companyGateway;

    /**
     * UseCompany constructor.
     * @param CompanyGateway $companyGateway
     */
    public function __construct(
        CompanyGateway $companyGateway
    ) {
        $this->companyGateway = $companyGateway;
    }

    /**
     * @param Company $company
     * @return Company
     */
    public function create(Company $company): Company
    {
        Assert::lazy()
            ->that($company->getCode(), "code")->notBlank()
            ->that($company->getName(), "name")->notBlank()
            ->that($company->getDescription(), "description")->notBlank()
            ->verifyNow()
        ;

        $this->companyGateway->create($company);
        return $company;
    }

    /**
     * @param Company $company
     * @return Company|null
     */
    public function show(?Company $company): ?Company
    {
        return $company;
    }

    /**
     * @return Company[]|null
     */
    public function findAll(): ?array
    {
        return $this->companyGateway->findAll();
    }

    /**
     * @param Company|null $company
     * @return Company|null
     */
    public function update(?Company $company): ?Company
    {
        $this->companyGateway->update($company);
        return $company;
    }

    /**
     * @param Company|null $company
     * @param bool $status
     * @return Company|null
     */
    public function activate(?Company $company, bool $status): ?Company
    {
        $this->companyGateway->activate($company, $status);

        return $company;
    }

    /**
     * @param Company|null $company
     * @param bool $status
     * @return Company|null
     */
    public function validate(?Company $company, bool $status): ?Company
    {
        $this->companyGateway->validate($company, $status);

        return $company;
    }

    /**
     * @param Company|null $company
     */
    public function delete(?Company $company)
    {
        $this->companyGateway->remove($company);
    }
}
