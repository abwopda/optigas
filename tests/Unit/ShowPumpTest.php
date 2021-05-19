<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\showPump;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowPumpTest
 * @package App\Tests\Unit
 */
class ShowPumpTest extends TestCase
{
    public function testSuccessfulPumpShowed()
    {
        $useCase = new showPump(new PumpRepository());

        $this->assertInstanceOf(Pump::class, $useCase->execute(1));
    }

    /**
     * @dataProvider provideBadPump
     * @param int $pump
     */
    public function testBadPump(int $pump)
    {
        $useCase = new showPump(new PumpRepository());

        $this->assertNull($useCase->execute($pump));
    }

    /**
     * @return \Generator
     */
    public function provideBadPump(): \Generator
    {
        yield [
            20
        ];
    }
}
