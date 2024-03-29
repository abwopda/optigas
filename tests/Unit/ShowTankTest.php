<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UseTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowTankTest
 * @package App\Tests\Unit
 */
class ShowTankTest extends TestCase
{
    public function testSuccessfulTankShowed()
    {
        $useCase = new UseTank(new TankRepository());
        for ($i = 4; $i <= 4; $i++) {
            $entity = (new TankRepository())->findOneById($i);
            $this->assertInstanceOf(Tank::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadTank
     * @param Tank|null $tank
     */
    public function testBadTank(?Tank $tank)
    {
        $useCase = new UseTank(new TankRepository());

        $this->assertNull($useCase->show($tank));
    }

    /**
     * @return \Generator
     */
    public function provideBadTank(): \Generator
    {
        yield [
            (new TankRepository())->findOneById(50)
        ];
    }
}
