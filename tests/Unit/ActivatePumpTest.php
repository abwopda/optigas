<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\ActivatePump;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivatePumpTest
 * @package App\Tests\Unit
 */
class ActivatePumpTest extends TestCase
{
    public function testSuccessfulPumpActivated()
    {
        $useCase = new activatePump(new PumpRepository());
        $pump = $useCase->execute(1, 1);

        //var_export($pump);

        $this->assertInstanceOf(Pump::class, $pump);

        $pump = $useCase->execute(1, 0);

        //var_export($pump);

        $this->assertInstanceOf(Pump::class, $pump);
    }
}
