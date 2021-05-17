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
     * @param Pos $pos
     * @param bool $status
     */
    public function activate(Pos $pos, bool $status): void;

    /**
     * @param int $id
     * @return Pos|null
     */
    public function findOneById(int $id): ?Pos;
}
