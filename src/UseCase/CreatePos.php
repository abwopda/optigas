<?php

namespace App\UseCase;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Assert\Assert;

/**
 * Class CreatePos
 * @package App\UseCase
 */
class CreatePos
{
    /**
     * @var PosGateway
     */
    private PosGateway $posGateway;

    /**
     * CreatePos constructor.
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
    public function execute(Pos $pos): Pos
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
}
