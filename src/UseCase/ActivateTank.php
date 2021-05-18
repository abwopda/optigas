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
     * @param Tank $tank
     * @return Tank
     */
    public function execute(int $tank, bool $status): Tank
    {
        $t = $this->tankGateway->findOneById($tank);

        $this->tankGateway->activate($t, $status);

        return $t;
    }
}
