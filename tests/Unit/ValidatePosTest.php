<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\ValidatePos;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatePosTest
 * @package App\Tests\Unit
 */
class ValidatePosTest extends TestCase
{
    public function testSuccessfulPosValidated()
    {
        $useCase = new validatePos(new PosRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new PosRepository())->findOneById($i);

            $this->assertInstanceOf(Pos::class, $useCase->execute($entity, true));

            $this->assertInstanceOf(Pos::class, $useCase->execute($entity, false));
        }
    }
}
