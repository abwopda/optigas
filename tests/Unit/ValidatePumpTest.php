<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\ValidatePump;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatePumpTest
 * @package App\Tests\Unit
 */
class ValidatePumpTest extends TestCase
{
    public function testSuccessfulPumpValidated()
    {
        $useCase = new validatePump(new PumpRepository());
        $pump = $useCase->execute(1, 1);

        //var_export($pump);

        $this->assertInstanceOf(Pump::class, $pump);

        $pump = $useCase->execute(1, 0);

        //var_export($pump);

        $this->assertInstanceOf(Pump::class, $pump);
    }
}
