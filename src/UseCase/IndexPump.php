<?php

namespace App\UseCase;

use App\Entity\Pump;
use App\Gateway\PumpGateway;
use Assert\Assert;

/**
 * Class IndexPump
 * @package App\UseCase
 */
class IndexPump
{
    /**
     * @var PumpGateway
     */
    private PumpGateway $pumpGateway;

    /**
     * IndexPump constructor.
     * @param PumpGateway $pumpGateway
     */
    public function __construct(PumpGateway $pumpGateway)
    {
        $this->pumpGateway = $pumpGateway;
    }


    /**
     * @return Pump[]|null
     */
    public function execute(): ?array
    {
        return $this->pumpGateway->findAll();
    }
}
