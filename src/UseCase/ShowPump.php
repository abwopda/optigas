<?php

namespace App\UseCase;

use App\Entity\Pump;
use App\Gateway\PumpGateway;
use Assert\Assert;

/**
 * Class ShowPump
 * @package App\UseCase
 */
class ShowPump
{
    /**
     * @var PumpGateway
     */
    private PumpGateway $pumpGateway;

    /**
     * ShowPump constructor.
     * @param PumpGateway $pumpGateway
     */
    public function __construct(PumpGateway $pumpGateway)
    {
        $this->pumpGateway = $pumpGateway;
    }


    /**
     * @param Pump $pump
     * @return Pump|null
     */
    public function execute(?Pump $pump): ?Pump
    {
        return $pump;
    }
}
