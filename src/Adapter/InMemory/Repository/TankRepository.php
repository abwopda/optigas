<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Pos;
use App\Entity\Tank;
use App\Gateway\TankGateway;

/**
 * Class PosRepository
 * @package App\Adapter\InMemory\Repository
 */
class TankRepository implements TankGateway
{
    public function create(Tank $tank): void
    {
    }
}
