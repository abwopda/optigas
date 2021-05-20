<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Assert\Assert;

/**
 * Class ActivateTank
 * @package App\UseCase
 */
class ActivateTank
{
    /**
     * @var TankGateway
     */
    private TankGateway $tankGateway;

    /**
     * ActivateTank constructor.
     * @param TankGateway $tankGateway
     */
    public function __construct(TankGateway $tankGateway)
    {
        $this->tankGateway = $tankGateway;
    }


    /**
     * @param Tank|null $tank
     * @param bool $status
     * @return Tank|null
     */
    public function execute(?Tank $tank, bool $status): ?Tank
    {
        $this->tankGateway->activate($tank, $status);

        return $tank;
    }
}
