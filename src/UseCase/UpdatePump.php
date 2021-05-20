<?php

namespace App\UseCase;

use App\Entity\Pump;
use App\Gateway\PumpGateway;

/**
 * Class UpdatePump
 * @package App\UseCase
 */
class UpdatePump
{
    /**
     * @var PumpGateway
     */
    private PumpGateway $pumpGateway;

    /**
     * UpdatePump constructor.
     * @param PumpGateway $pumpGateway
     */
    public function __construct(PumpGateway $pumpGateway)
    {
        $this->pumpGateway = $pumpGateway;
    }

    /**
     * @param Pump|null $pump
     * @return Pump|null
     */
    public function execute(?Pump $pump): ?Pump
    {
        $this->pumpGateway->update($pump);
        return $pump;
    }
}
