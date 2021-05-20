<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;

/**
 * Class UpdateTank
 * @package App\UseCase
 */
class UpdateTank
{
    /**
     * @var TankGateway
     */
    private TankGateway $tankGateway;

    /**
     * UpdateTank constructor.
     * @param TankGateway $tankGateway
     */
    public function __construct(TankGateway $tankGateway)
    {
        $this->tankGateway = $tankGateway;
    }


    /**
     * @param Tank|null $tank
     * @return Tank|null
     */
    public function execute(?Tank $tank): ?Tank
    {
        $this->tankGateway->update($tank);
        return $tank;
    }
}
