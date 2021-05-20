<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\ShowPos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowPosTest
 * @package App\Tests\Unit
 */
class ShowPosTest extends TestCase
{
    public function testSuccessfulPosShowed()
    {
        $useCase = new ShowPos(new PosRepository());
        for ($i = 1; $i <= 3; $i++) {
            $entity = (new PosRepository())->findOneById($i);
            $this->assertInstanceOf(Pos::class, $useCase->execute($entity));
        }
    }

    /**
     * @dataProvider provideBadPos
     * @param Pos|null $pos
     */
    public function testBadPos(?Pos $pos)
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
            (new PosRepository())->findOneById(5)
        ];
    }
}
