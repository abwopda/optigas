<?php

namespace App\UseCase;

use App\Entity\Pump;
use App\Gateway\PumpGateway;
use Assert\Assert;

/**
 * Class CreatePump
 * @package App\UseCase
 */
class CreatePump
{
    /**
     * @var PumpGateway
     */
    private PumpGateway $pumpGateway;

    /**
     * CreatePump constructor.
     * @param PumpGateway $pumpGateway
     */
    public function __construct(
        PumpGateway $pumpGateway
    ) {
        $this->pumpGateway = $pumpGateway;
    }


    public function execute(Pump $pump): Pump
    {
        Assert::lazy()
            ->that($pump->getCode(), "code")->notBlank()
            ->that($pump->getName(), "name")->notBlank()
            ->that($pump->getDescription(), "description")->notBlank()
            ->that($pump->getCounter(), "counter")
            ->notBlank()
            ->integer()
            ->greaterThan(0)
            ->verifyNow()
        ;

        $this->pumpGateway->create($pump);
        return $pump;
    }
}
