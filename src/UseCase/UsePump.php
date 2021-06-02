<?php

namespace App\UseCase;

use App\Entity\Pump;
use App\Gateway\PumpGateway;
use Assert\Assert;

/**
 * Class UsePump
 * @package App\UseCase
 */
class UsePump
{
    /**
     * @var PumpGateway
     */
    private PumpGateway $pumpGateway;

    /**
     * UsePump constructor.
     * @param PumpGateway $pumpGateway
     */
    public function __construct(
        PumpGateway $pumpGateway
    ) {
        $this->pumpGateway = $pumpGateway;
    }


    public function create(Pump $pump): Pump
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

    /**
     * @param Pump $pump
     * @return Pump|null
     */
    public function show(?Pump $pump): ?Pump
    {
        return $pump;
    }

    /**
     * @return Pump[]|null
     */
    public function findAll(): ?array
    {
        return $this->pumpGateway->findAll();
    }

    /**
     * @param Pump|null $pump
     * @return Pump|null
     */
    public function update(?Pump $pump): ?Pump
    {
        $this->pumpGateway->update($pump);
        return $pump;
    }

    /**
     * @param Pump|null $pump
     * @param bool $status
     * @return Pump|null
     */
    public function activate(?Pump $pump, bool $status): ?Pump
    {
        $this->pumpGateway->activate($pump, $status);

        return $pump;
    }

    /**
     * @param Pump|null $pump
     * @param bool $status
     * @return Pump|null
     */
    public function validate(?Pump $pump, bool $status): ?Pump
    {
        $this->pumpGateway->validate($pump, $status);

        return $pump;
    }

    /**
     * @param Pump|null $pump
     */
    public function delete(?Pump $pump)
    {
        $this->pumpGateway->remove($pump);
    }
}
