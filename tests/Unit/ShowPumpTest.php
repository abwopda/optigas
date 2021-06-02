<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\UsePump;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowPumpTest
 * @package App\Tests\Unit
 */
class ShowPumpTest extends TestCase
{
    public function testSuccessfulPumpShowed()
    {
        $useCase = new UsePump(new PumpRepository());
        for ($i = 11; $i <= 11; $i++) {
            $entity = (new PumpRepository())->findOneById($i);
            $this->assertInstanceOf(Pump::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadPump
     * @param Pump|null $pump
     */
    public function testBadPump(?Pump $pump)
    {
        $useCase = new UsePump(new PumpRepository());

        $this->assertNull($useCase->show($pump));
    }

    /**
     * @return \Generator
     */
    public function provideBadPump(): \Generator
    {
        yield [
            (new PumpRepository())->findOneById(50)
        ];
    }
}
