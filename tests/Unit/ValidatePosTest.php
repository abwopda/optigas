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
        for ($i = 1; $i <= 3; $i++) {
            $entity = (new PosRepository())->findOneById($i);

            $this->assertInstanceOf(Pos::class, $useCase->execute($entity, 1));

            $this->assertInstanceOf(Pos::class, $useCase->execute($entity, 0));
        }
    }
}
