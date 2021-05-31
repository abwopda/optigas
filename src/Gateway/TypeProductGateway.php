<?php

namespace App\Gateway;

use App\Entity\TypeProduct;

/**
 * Interface TypeProductGateway
 * @package App\Gateway
 */
interface TypeProductGateway
{
    /**
     * @param TypeProduct $typeproduct
     */
    public function create(TypeProduct $typeproduct): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param TypeProduct $typeproduct
     */
    public function update(TypeProduct $typeproduct): void;

    /**
     * @param TypeProduct $typeproduct
     */
    public function remove(TypeProduct $typeproduct): void;

    /**
     * @param TypeProduct $typeproduct
     * @param bool $status
     */
    public function activate(TypeProduct $typeproduct, bool $status): void;

    /**
     * @param TypeProduct $typeproduct
     * @param bool $status
     */
    public function validate(TypeProduct $typeproduct, bool $status): void;

    /**
     * @param int $id
     * @return TypeProduct|null
     */
    public function findOneById(int $id): ?TypeProduct;

    /**
     * @return TypeProduct[]|null
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
