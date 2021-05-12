<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Assert\Assert;

/**
 * Class CreateTank
 * @package App\UseCase
 */
class CreateTank
{
    /**
     * @var TankGateway
     */
    private TankGateway $tankGateway;

    /**
     * CreateTank constructor.
     * @param TankGateway $tankGateway
     */
    public function __construct(
        TankGateway $tankGateway
    ) {
        $this->tankGateway = $tankGateway;
    }


    public function execute(Tank $tank): Tank
    {
        Assert::lazy()
            ->that($tank->getCode(), "code")->notBlank()
            ->that($tank->getName(), "name")->notBlank()
            ->that($tank->getDescription(), "description")->notBlank()
            ->that($tank->getCapacity(), "capacity")
            ->notBlank()
            ->integer()
            ->greaterThan(0)
            ->verifyNow()
        ;

        $this->tankGateway->create($tank);
        return $tank;
    }
}
