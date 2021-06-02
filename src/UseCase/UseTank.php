<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Assert\Assert;

/**
 * Class UseTank
 * @package App\UseCase
 */
class UseTank
{
    /**
     * @var TankGateway
     */
    private TankGateway $tankGateway;

    /**
     * UseTank constructor.
     * @param TankGateway $tankGateway
     */
    public function __construct(
        TankGateway $tankGateway
    ) {
        $this->tankGateway = $tankGateway;
    }

    /**
     * @param Tank $tank
     * @return Tank
     */
    public function create(Tank $tank): Tank
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

    /**
     * @param Tank $tank
     * @return Tank|null
     */
    public function show(?Tank $tank): ?Tank
    {
        return $tank;
    }

    /**
     * @return Tank[]|null
     */
    public function findAll(): ?array
    {
        return $this->tankGateway->findAll();
    }

    /**
     * @param Tank|null $tank
     * @return Tank|null
     */
    public function update(?Tank $tank): ?Tank
    {
        $this->tankGateway->update($tank);
        return $tank;
    }

    /**
     * @param Tank|null $tank
     * @param bool $status
     * @return Tank|null
     */
    public function activate(?Tank $tank, bool $status): ?Tank
    {
        $this->tankGateway->activate($tank, $status);

        return $tank;
    }

    /**
     * @param Tank|null $tank
     * @param bool $status
     * @return Tank|null
     */
    public function validate(?Tank $tank, bool $status): ?Tank
    {
        $this->tankGateway->validate($tank, $status);

        return $tank;
    }

    /**
     * @param Tank|null $tank
     */
    public function delete(?Tank $tank)
    {
        $this->tankGateway->remove($tank);
    }
}
