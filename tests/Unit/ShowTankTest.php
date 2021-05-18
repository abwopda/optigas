<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\showTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTankTest
 * @package App\Tests\Unit
 */
class ShowTankTest extends TestCase
{
    public function testSuccessfulTankShowed()
    {
        $useCase = new showTank(new TankRepository());

        $this->assertInstanceOf(Tank::class, $useCase->execute(1));
    }

    /**
     * @dataProvider provideBadTank
     * @param int $tank
     */
    public function testBadTank(int $tank)
    {
        $useCase = new showTank(new TankRepository());

        $this->assertNull($useCase->execute($tank));
    }

    /**
     * @return \Generator
     */
    public function provideBadTank(): \Generator
    {
        yield [
            5
        ];
    }
}
