<?php

namespace App\UseCase;

use App\Entity\Pump;
use App\Gateway\PumpGateway;
use Assert\Assert;

/**
 * Class ActivatePump
 * @package App\UseCase
 */
class ActivatePump
{
    /**
     * @var PumpGateway
     */
    private PumpGateway $pumpGateway;

    /**
     * ActivatePump constructor.
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
        $p = $this->pumpGateway->findOneById($pump);

        $this->pumpGateway->activate($p, $status);

        return $p;
    }
}
