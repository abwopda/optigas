<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\showPump;
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
        for ($i = 11; $i <= 11; $i++) {
            $entity = (new PumpRepository())->findOneById($i);
            $this->assertInstanceOf(Pump::class, $useCase->execute($entity));
        }
    }

    /**
     * @dataProvider provideBadPump
     * @param Pump|null $pump
     */
    public function testBadPump(?Pump $pump)
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
            (new PumpRepository())->findOneById(50)
        ];
    }
}
