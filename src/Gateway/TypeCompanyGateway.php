<?php

namespace App\Gateway;

use App\Entity\TypeCompany;

/**
 * Interface TypeCompanyGateway
 * @package App\Gateway
 */
interface TypeCompanyGateway
{
    /**
     * @param TypeCompany $typecompany
     */
    public function create(TypeCompany $typecompany): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param TypeCompany $typecompany
     */
    public function update(TypeCompany $typecompany): void;

    /**
     * @param TypeCompany $typecompany
     */
    public function remove(TypeCompany $typecompany): void;

    /**
     * @param TypeCompany $typecompany
     * @param bool $status
     */
    public function activate(TypeCompany $typecompany, bool $status): void;

    /**
     * @param TypeCompany $typecompany
     * @param bool $status
     */
    public function validate(TypeCompany $typecompany, bool $status): void;

    /**
     * @param int $id
     * @return TypeCompany|null
     */
    public function findOneById(int $id): ?TypeCompany;

    /**
     * @return TypeCompany[]|null
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
}
