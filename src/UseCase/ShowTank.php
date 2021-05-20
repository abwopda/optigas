<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Assert\Assert;

/**
 * Class ShowTank
 * @package App\UseCase
 */
class ShowTank
{
    /**
     * @var TankGateway
     */
    private TankGateway $tankGateway;

    /**
     * ShowTank constructor.
     * @param TankGateway $tankGateway
     */
    public function __construct(TankGateway $tankGateway)
    {
        $this->tankGateway = $tankGateway;
    }


    /**
     * @param Tank $tank
     * @return Tank|null
     */
    public function execute(?Tank $tank): ?Tank
    {
        return $tank;
    }
}
