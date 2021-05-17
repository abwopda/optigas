<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\ActivatePos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivatePosTest
 * @package App\Tests\Unit
 */
class ActivatePosTest extends TestCase
{
    public function testSuccessfulPosActivated()
    {
        $useCase = new activatePos(new PosRepository());
        $pos = $useCase->execute(1, 1);

        //var_export($pos);

        $this->assertInstanceOf(Pos::class, $pos);

        $pos = $useCase->execute(1, 0);

        //var_export($pos);

        $this->assertInstanceOf(Pos::class, $pos);
    }
}
