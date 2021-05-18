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
     * @param int $id
     * @return Tank|null
     */
    public function findOneById(int $id): ?Tank;

    /**
     * @param Tank $tank
     */
    public function update(Tank $tank): void;

    /**
     * @param Tank $tank
     * @param bool $status
     */
    public function activate(Tank $tank, bool $status): void;
}
