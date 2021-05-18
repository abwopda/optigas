<?php

namespace App\UseCase;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Assert\Assert;

/**
 * Class ShowPos
 * @package App\UseCase
 */
class ShowPos
{
    /**
     * @var PosGateway
     */
    private PosGateway $posGateway;

    /**
     * ShowPos constructor.
     * @param PosGateway $posGateway
     */
    public function __construct(PosGateway $posGateway)
    {
        $this->posGateway = $posGateway;
    }


    /**
     * @param Pos $pos
     * @return Pos|null
     */
    public function execute(int $pos): ?Pos
    {
        return $this->posGateway->findOneById($pos);
    }
}