<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Assert\Assert;

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
     * @param Tank $tank
     * @return Tank
     */
    public function execute(int $tank): Tank
    {
        $t = $this->tankGateway->findOneById($tank);

        $this->tankGateway->update($t);
        return $t;
    }
}
