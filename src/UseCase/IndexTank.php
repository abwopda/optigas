<?php

namespace App\UseCase;

use App\Entity\Tank;
use App\Gateway\TankGateway;
use Assert\Assert;

/**
 * Class IndexTank
 * @package App\UseCase
 */
class IndexTank
{
    /**
     * @var TankGateway
     */
    private TankGateway $tankGateway;

    /**
     * IndexTank constructor.
     * @param TankGateway $tankGateway
     */
    public function __construct(TankGateway $tankGateway)
    {
        $this->tankGateway = $tankGateway;
    }


    /**
     * @return Tank[]|null
     */
    public function execute(): ?array
    {
        return $this->tankGateway->findAll();
    }
}
