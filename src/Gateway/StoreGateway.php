<?php

namespace App\Gateway;

use App\Entity\Store;

/**
 * Interface StoreGateway
 * @package App\Gateway
 */
interface StoreGateway
{
    /**
     * @param Store $store
     */
    public function create(Store $store): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param Store $store
     */
    public function update(Store $store): void;

    /**
     * @param Store $store
     */
    public function remove(Store $store): void;

    /**
     * @param Store $store
     * @param bool $status
     */
    public function activate(Store $store, bool $status): void;

    /**
     * @param Store $store
     * @param bool $status
     */
    public function validate(Store $store, bool $status): void;

    /**
     * @param int $id
     * @return Store|null
     */
    public function findOneById(int $id): ?Store;

    /**
     * @return Store[]|null
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
