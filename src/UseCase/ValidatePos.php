<?php

namespace App\UseCase;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Assert\Assert;

/**
 * Class ValidatePos
 * @package App\UseCase
 */
class ValidatePos
{
    /**
     * @var PosGateway
     */
    private PosGateway $posGateway;

    /**
     * ValidatePos constructor.
     * @param PosGateway $posGateway
     */
    public function __construct(PosGateway $posGateway)
    {
        $this->posGateway = $posGateway;
    }


    /**
     * @param Pos|null $pos
     * @param bool $status
     * @return Pos|null
     */
    public function execute(?Pos $pos, bool $status): ?Pos
    {
        $this->posGateway->validate($pos, $status);

        return $pos;
    }
}
