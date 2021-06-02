<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UsePos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreatePosTest
 * @package App\Tests\Unit
 */
class CreatePosTest extends TestCase
{
    public function testSuccessfulPosCreated()
    {
        $useCase = new UsePos(new PosRepository());

        $pos = (new Pos())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setTown("town")
            ->setAddress("address")
            ->setCapacity(60000)
        ;

        $this->AssertEquals($pos, $useCase->create($pos));
    }
    /**
     * @dataProvider provideBadPos
     * @param Pos $pos
     */
    public function testBadPos(Pos $pos)
    {
        $useCase = new UsePos(new PosRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($pos, $useCase->create($pos));
    }

    /**
     * @return \Generator
     */
    public function provideBadPos(): \Generator
    {
        yield[
            (new Pos())
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("address")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("address")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("address")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setName("")
                ->setTown("town")
                ->setAddress("address")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setName("name")
                ->setDescription("")
                ->setTown("town")
                ->setAddress("address")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setAddress("address")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setTown("")
                ->setAddress("address")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("")
                ->setCapacity(60000)
        ];
        yield[
            (new Pos())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("address")
        ];
    }
}
