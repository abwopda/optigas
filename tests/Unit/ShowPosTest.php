<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\showPos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdatePosTest
 * @package App\Tests\Unit
 */
class ShowPosTest extends TestCase
{
    public function testSuccessfulPosShowed()
    {
        $useCase = new showPos(new PosRepository());

        $this->assertInstanceOf(Pos::class, $useCase->execute(1));
    }

    /**
     * @dataProvider provideBadPos
     * @param int $pos
     */
    public function testBadPos(int $pos)
    {
        $useCase = new showPos(new PosRepository());

        $this->assertNull($useCase->execute($pos));
    }

    /**
     * @return \Generator
     */
    public function provideBadPos(): \Generator
    {
        yield [
            5
        ];
    }
}
