<?php

namespace App\Gateway;

use App\Entity\CompanyFamily;

/**
 * Interface CompanyFamilyGateway
 * @package App\Gateway
 */
interface CompanyFamilyGateway
{
    /**
     * @param CompanyFamily $companyfamily
     */
    public function create(CompanyFamily $companyfamily): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param int $id
     * @return CompanyFamily|null
     */
    public function findOneById(int $id): ?CompanyFamily;

    /**
     * @return CompanyFamily[]|null
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
     * @param CompanyFamily $companyfamily
     */
    public function update(CompanyFamily $companyfamily): void;

    /**
     * @param CompanyFamily $companyfamily
     */
    public function remove(CompanyFamily $companyfamily): void;

    /**
     * @param CompanyFamily $companyfamily
     * @param bool $status
     */
    public function activate(CompanyFamily $companyfamily, bool $status): void;

    /**
     * @param CompanyFamily $companyfamily
     * @param bool $status
     */
    public function validate(CompanyFamily $companyfamily, bool $status): void;
}
