<?php

namespace App\Gateway;

use App\Entity\Tank;

/**
 * Interface TankGateway
 * @package App\Gateway
 */
interface TankGateway
{
    /**
     * @param Tank $tank
     */
    public function create(Tank $tank): void;

    /**
     * @return string
     */
    public function getTypeClass(): string;

    /**
     * @param int $id
     * @return Tank|null
     */
    public function findOneById(int $id): ?Tank;

    /**
     * @return Tank[]|null
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
     * @param Tank $tank
     */
    public function update(Tank $tank): void;

    /**
     * @param Tank $tank
     */
    public function remove(Tank $tank): void;

    /**
     * @param Tank $tank
     * @param bool $status
     */
    public function activate(Tank $tank, bool $status): void;

    /**
     * @param Tank $tank
     * @param bool $status
     */
    public function validate(Tank $tank, bool $status): void;
}
