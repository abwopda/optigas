<?php

namespace App\UseCase;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use Assert\Assert;

/**
 * Class IndexPos
 * @package App\UseCase
 */
class IndexPos
{
    /**
     * @var PosGateway
     */
    private PosGateway $posGateway;

    /**
     * IndexPos constructor.
     * @param PosGateway $posGateway
     */
    public function __construct(PosGateway $posGateway)
    {
        $this->posGateway = $posGateway;
    }


    /**
     * @return Pos[]|null
     */
    public function execute(): ?array
    {
        return $this->posGateway->findAll();
    }
}
