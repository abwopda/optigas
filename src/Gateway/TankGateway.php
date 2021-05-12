<?php

namespace App\Gateway;

use App\Entity\Pos;
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
}
