<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pos;
use App\Entity\Tank;
use App\Entity\Pump;
use App\UseCase\CreatePump;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreatePumpTest
 * @package App\Tests\Unit
 */
class CreatePumpTest extends TestCase
{
    public function testSuccessfulPumpCreated()
    {
        $useCase = new CreatePump(new PumpRepository());

        $pos = (new Pos())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setTown("town")
            ->setAddress("address")
            ->setCapacity(60000)
        ;

        $tank = (new Tank($pos))
            ->setCode("CUV0000")
            ->setName("Cuve Super")
            ->setDescription("Tawaal oil XXX")
            ->setCapacity(20000)
        ;

        $pump = (new Pump($tank))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setCounter(4578952)
        ;

        $this->AssertEquals($pump, $useCase->execute($pump));
    }
    /**
     * @dataProvider provideBadPump
     * @param Pump $pump
     */
    public function testBadPump(Pump $pump)
    {
        $useCase = new CreatePump(new PumpRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($pump, $useCase->execute($pump));
    }

    /**
     * @return \Generator
     */
    public function provideBadPump(): \Generator
    {
        $pos = (new Pos())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setTown("town")
            ->setAddress("address")
            ->setCapacity(60000)
        ;

        $tank = (new Tank($pos))
            ->setCode("CUV0000")
            ->setName("Cuve Super")
            ->setDescription("Tawaal oil XXX")
            ->setCapacity(20000)
        ;

        yield [
            (new Pump($tank))
                ->setName("name")
                ->setDescription("description")
                ->setCounter(4578952)
        ];
        yield [
            (new Pump($tank))
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
                ->setCounter(4578952)
        ];
        yield [
            (new Pump($tank))
                ->setCode("code")
                ->setDescription("description")
                ->setCounter(4578952)
        ];
        yield [
            (new Pump($tank))
                ->setCode("code")
                ->setName("")
                ->setDescription("description")
                ->setCounter(4578952)
        ];
        yield [
            (new Pump($tank))
                ->setCode("code")
                ->setName("name")
                ->setCounter(4578952)
        ];
        yield [
            (new Pump($tank))
                ->setCode("code")
                ->setName("name")
                ->setDescription("")
                ->setCounter(4578952)
        ];
        yield [
            (new Pump($tank))
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
        ];
    }
}
