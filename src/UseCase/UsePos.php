<?php

namespace App\UseCase;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Assert\Assert;

/**
 * Class UsePos
 * @package App\UseCase
 */
class UsePos
{
    /**
     * @var PosGateway
     */
    private PosGateway $posGateway;

    /**
     * UsePos constructor.
     * @param PosGateway $posGateway
     */
    public function __construct(PosGateway $posGateway)
    {
        $this->posGateway = $posGateway;
    }


    /**
     * @param Pos $pos
     * @return Pos
     */
    public function create(Pos $pos): Pos
    {
        //var_export($pos);
        Assert::lazy()
            ->that($pos->getCode(), "code")->notBlank()
            ->that($pos->getName(), "name")->notBlank()
            ->that($pos->getDescription(), "description")->notBlank()
            ->that($pos->getAddress(), "address")->notBlank()
            ->that($pos->getTown(), "town")->notBlank()
            ->that($pos->getCapacity(), "capacity")
                ->notBlank()
                ->integer()
                ->greaterThan(0)
            ->verifyNow()
        ;

        $this->posGateway->create($pos);
        return $pos;
    }

    /**
     * @param Pos|null $pos
     * @return Pos|null
     */
    public function show(?Pos $pos): ?Pos
    {
        return $pos;
    }

    /**
     * @return Pos[]|null
     */
    public function findAll(): ?array
    {
        return $this->posGateway->findAll();
    }

    /**
     * @param Pos|null $pos
     * @return Pos|null
     */
    public function update(?Pos $pos): ?Pos
    {
        $this->posGateway->update($pos);
        return $pos;
    }

    /**
     * @param Pos|null $pos
     * @param bool $status
     * @return Pos|null
     */
    public function activate(?Pos $pos, bool $status): ?Pos
    {
        $this->posGateway->activate($pos, $status);

        return $pos;
    }

    /**
     * @param Pos|null $pos
     * @param bool $status
     * @return Pos|null
     */
    public function validate(?Pos $pos, bool $status): ?Pos
    {
        $this->posGateway->validate($pos, $status);

        return $pos;
    }

    /**
     * @param Pos|null $pos
     */
    public function delete(?Pos $pos)
    {
        $this->posGateway->remove($pos);
    }
}
