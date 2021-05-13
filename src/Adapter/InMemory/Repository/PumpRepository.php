<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Pos;
use App\Entity\Pump;
use App\Gateway\PumpGateway;

/**
 * Class PumpRepository
 * @package App\Adapter\InMemory\Repository
 */
class PumpRepository implements PumpGateway
{
    public function create(Pump $pump): void
    {
    }
}
