<?php

namespace App\UseCase;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Assert\Assert;

/**
 * Class ActivatePos
 * @package App\UseCase
 */
class ActivatePos
{
    /**
     * @var PosGateway
     */
    private PosGateway $posGateway;

    /**
     * ActivatePos constructor.
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
        $this->posGateway->activate($pos, $status);

        return $pos;
    }
}
