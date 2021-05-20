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
     * @param Pump|null $pump
     * @param bool $status
     * @return Pump|null
     */
    public function execute(?Pump $pump, bool $status): ?Pump
    {
        $this->pumpGateway->validate($pump, $status);

        return $pump;
    }
}
