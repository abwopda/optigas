<?php

namespace App\Gateway;

use App\Entity\Pos;

/**
 * Interface PosGateway
 * @package App\Gateway
 */
interface PosGateway
{
    /**
     * @param Pos $pos
     */
    public function create(Pos $pos): void;
}
