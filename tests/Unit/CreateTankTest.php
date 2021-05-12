<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Pos;
use App\Entity\Tank;
use App\UseCase\CreateTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateTankTest
 * @package App\Tests\Unit
 */
class CreateTankTest extends TestCase
{
    public function testSuccessfulTankCreated()
    {
        $useCase = new CreateTank(new TankRepository());

        $pos = (new Pos())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setTown("town")
            ->setAddress("address")
            ->setCapacity(60000)
        ;

        $tank = (new Tank($pos))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setCapacity(30000)
        ;

        $this->AssertEquals($tank, $useCase->execute($tank));
    }
    /**
     * @dataProvider provideBadTank
     * @param Tank $tank
     */
    public function testBadTank(Tank $tank)
    {
        $useCase = new CreateTank(new TankRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($tank, $useCase->execute($tank));
    }

    /**
     * @return \Generator
     */
    public function provideBadTank(): \Generator
    {
        $pos = (new Pos())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setTown("town")
            ->setAddress("address")
            ->setCapacity(60000)
        ;

        yield [
            (new Tank($pos))
                ->setName("name")
                ->setDescription("description")
                ->setCapacity(30000)
        ];
        yield [
            (new Tank($pos))
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
                ->setCapacity(30000)
        ];
        yield [
            (new Tank($pos))
                ->setName("code")
                ->setDescription("description")
                ->setCapacity(30000)
        ];
        yield [
            (new Tank($pos))
                ->setCode("code")
                ->setName("")
                ->setDescription("description")
                ->setCapacity(30000)
        ];
        yield [
            (new Tank($pos))
                ->setCode("code")
                ->setName("name")
                ->setCapacity(30000)
        ];
        yield [
            (new Tank($pos))
                ->setName("code")
                ->setName("name")
                ->setDescription("")
                ->setCapacity(30000)
        ];
        yield [
            (new Tank($pos))
                ->setName("code")
                ->setName("name")
                ->setDescription("description")
        ];
    }
}
