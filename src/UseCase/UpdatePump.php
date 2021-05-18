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
     * @param Pump $pump
     * @return Pump
     */
    public function execute(int $pump): Pump
    {
        $p = $this->pumpGateway->findOneById($pump);

        $this->pumpGateway->update($p);
        return $p;
    }
}
