<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UpdatePos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdatePosTest
 * @package App\Tests\Unit
 */
class UpdatePosTest extends TestCase
{
    public function testSuccessfulPosUpdated()
    {
        $useCase = new updatePos(new PosRepository());

        $this->assertInstanceOf(Pos::class, $useCase->execute(1));
    }
}
