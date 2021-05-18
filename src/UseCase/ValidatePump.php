<?php

namespace App\UseCase;

use App\Entity\Pump;
use App\Gateway\PumpGateway;
use Assert\Assert;

/**
 * Class ValidatePump
 * @package App\UseCase
 */
class ValidatePump
{
    /**
     * @var PumpGateway
     */
    private PumpGateway $pumpGateway;

    /**
     * ValidatePump constructor.
     * @param PumpGateway $pumpGateway
     */
    public function __construct(PumpGateway $pumpGateway)
    {
        $this->pumpGateway = $pumpGateway;
    }


    /**
     * @param Pump $pump
     * @return Pump
     */
    public function execute(int $pump, bool $status): Pump
    {
        $t = $this->pumpGateway->findOneById($pump);

        $this->pumpGateway->validate($t, $status);

        return $t;
    }
}
