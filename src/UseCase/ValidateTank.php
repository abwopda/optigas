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
     * @param Tank $tank
     * @return Tank
     */
    public function execute(int $tank, bool $status): Tank
    {
        $t = $this->tankGateway->findOneById($tank);

        $this->tankGateway->validate($t, $status);

        return $t;
    }
}
