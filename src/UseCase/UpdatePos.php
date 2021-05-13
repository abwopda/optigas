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
     * @param Pos $pos
     * @return Pos
     */
    public function execute(int $pos): Pos
    {
        $p = $this->posGateway->findOneById($pos);

        $this->posGateway->update($p);
        return $p;
    }
}
