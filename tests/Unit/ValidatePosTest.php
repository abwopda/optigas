<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\ValidatePos;
use Assert\LazyAssertionException;
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
        $pos = $useCase->execute(1, 1);

        //var_export($pos);

        $this->assertInstanceOf(Pos::class, $pos);

        $pos = $useCase->execute(1, 0);

        //var_export($pos);

        $this->assertInstanceOf(Pos::class, $pos);
    }
}
