<?php

namespace App\Gateway;

use App\Entity\Company;

/**
 * Interface CompanyGateway
 * @package App\Gateway
 */
interface CompanyGateway
{
    /**
     * @param Company $company
     */
    public function create(Company $company): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param int $id
     * @return Company|null
     */
    public function findOneById(int $id): ?Company;

    /**
     * @return Company[]|null
     */
    public function findAll(): ?array;

    /**
     * @param $searchParam
     */
    public function search($searchParam);

    /**
     * @return mixed
     */
    public function counter();

    /**
     * @param Company $company
     */
    public function update(Company $company): void;

    /**
     * @param Company $company
     */
    public function remove(Company $company): void;

    /**
     * @param Company $company
     * @param bool $status
     */
    public function activate(Company $company, bool $status): void;

    /**
     * @param Company $company
     * @param bool $status
     */
    public function validate(Company $company, bool $status): void;
}
