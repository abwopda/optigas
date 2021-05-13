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

    /**
     * @param Pos $pos
     */
    public function update(Pos $pos): void;

    /**
     * @param int $id
     * @return Pos
     */
    public function findOneById(int $id): Pos;
}
