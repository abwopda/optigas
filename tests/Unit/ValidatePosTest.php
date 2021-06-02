<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UsePos;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatePosTest
 * @package App\Tests\Unit
 */
class ValidatePosTest extends TestCase
{
    public function testSuccessfulPosValidated()
    {
        $useCase = new UsePos(new PosRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new PosRepository())->findOneById($i);

            $this->assertInstanceOf(Pos::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(Pos::class, $useCase->validate($entity, false));
        }
    }
}
