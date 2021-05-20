<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Assert\Assert;

/**
 * Class ValidateTank
 * @package App\UseCase
 */
class ValidateTank
{
    /**
     * @var TankGateway
     */
    private TankGateway $tankGateway;

    /**
     * ValidateTank constructor.
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
        $this->tankGateway->validate($tank, $status);

        return $tank;
    }
}
