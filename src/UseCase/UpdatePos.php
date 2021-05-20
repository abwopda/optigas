<?php

namespace App\UseCase;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Assert\Assert;

/**
 * Class UpdatePos
 * @package App\UseCase
 */
class UpdatePos
{
    /**
     * @var PosGateway
     */
    private PosGateway $posGateway;

    /**
     * UpdatePos constructor.
     * @param PosGateway $posGateway
     */
    public function __construct(PosGateway $posGateway)
    {
        $this->posGateway = $posGateway;
    }


    /**
     * @param Pos|null $pos
     * @return Pos|null
     */
    public function execute(?Pos $pos): ?Pos
    {
        $this->posGateway->update($pos);
        return $pos;
    }
}
