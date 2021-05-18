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
     * @param Pos $pos
     * @return Pos
     */
    public function execute(int $pos, bool $status): Pos
    {
        $p = $this->posGateway->findOneById($pos);

        $this->posGateway->validate($p, $status);

        return $p;
    }
}
