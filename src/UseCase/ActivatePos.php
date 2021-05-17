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
     * @param Pos $pos
     * @return Pos
     */
    public function execute(int $pos, bool $status): Pos
    {
        $p = $this->posGateway->findOneById($pos);

        $this->posGateway->activate($p, $status);

        return $p;
    }
}
