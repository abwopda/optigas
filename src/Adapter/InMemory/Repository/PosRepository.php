<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Pos;
use App\Gateway\PosGateway;

/**
 * Class PosRepository
 * @package App\Adapter\InMemory\Repository
 */
class PosRepository implements PosGateway
{
    public function create(Pos $pos): void
    {
    }
}
