<?php

namespace App\Gateway;

use App\Entity\Pos;
use App\Entity\Pump;

/**
 * Interface PumpGateway
 * @package App\Gateway
 */
interface PumpGateway
{
    /**
     * @param Pump $pump
     */
    public function create(Pump $pump): void;
}
