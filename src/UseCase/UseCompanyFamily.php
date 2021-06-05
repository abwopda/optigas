<?php

namespace App\UseCase;

use App\Entity\CompanyFamily;
use App\Gateway\CompanyFamilyGateway;
use Assert\Assert;

/**
 * Class UseCompanyFamily
 * @package App\UseCase
 */
class UseCompanyFamily
{
    /**
     * @var CompanyFamilyGateway
     */
    private CompanyFamilyGateway $companyfamilyGateway;

    /**
     * UseCompanyFamily constructor.
     * @param CompanyFamilyGateway $companyfamilyGateway
     */
    public function __construct(
        CompanyFamilyGateway $companyfamilyGateway
    ) {
        $this->companyfamilyGateway = $companyfamilyGateway;
    }

    /**
     * @param CompanyFamily $companyfamily
     * @return CompanyFamily
     */
    public function create(CompanyFamily $companyfamily): CompanyFamily
    {
        Assert::lazy()
            ->that($companyfamily->getCode(), "code")->notBlank()
            ->that($companyfamily->getName(), "name")->notBlank()
            ->that($companyfamily->getDescription(), "description")->notBlank()
            ->verifyNow()
        ;

        $this->companyfamilyGateway->create($companyfamily);
        return $companyfamily;
    }

    /**
     * @param CompanyFamily $companyfamily
     * @return CompanyFamily|null
     */
    public function show(?CompanyFamily $companyfamily): ?CompanyFamily
    {
        return $companyfamily;
    }

    /**
     * @return CompanyFamily[]|null
     */
    public function findAll(): ?array
    {
        return $this->companyfamilyGateway->findAll();
    }

    /**
     * @param CompanyFamily|null $companyfamily
     * @return CompanyFamily|null
     */
    public function update(?CompanyFamily $companyfamily): ?CompanyFamily
    {
        $this->companyfamilyGateway->update($companyfamily);
        return $companyfamily;
    }

    /**
     * @param CompanyFamily|null $companyfamily
     * @param bool $status
     * @return CompanyFamily|null
     */
    public function activate(?CompanyFamily $companyfamily, bool $status): ?CompanyFamily
    {
        $this->companyfamilyGateway->activate($companyfamily, $status);

        return $companyfamily;
    }

    /**
     * @param CompanyFamily|null $companyfamily
     * @param bool $status
     * @return CompanyFamily|null
     */
    public function validate(?CompanyFamily $companyfamily, bool $status): ?CompanyFamily
    {
        $this->companyfamilyGateway->validate($companyfamily, $status);

        return $companyfamily;
    }

    /**
     * @param CompanyFamily|null $companyfamily
     */
    public function delete(?CompanyFamily $companyfamily)
    {
        $this->companyfamilyGateway->remove($companyfamily);
    }
}
