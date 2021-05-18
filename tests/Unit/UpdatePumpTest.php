<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\UpdatePump;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdatePumpTest
 * @package App\Tests\Unit
 */
class UpdatePumpTest extends TestCase
{
    public function testSuccessfulPumpUpdated()
    {
        $useCase = new updatePump(new PumpRepository());

        $this->assertInstanceOf(Pump::class, $useCase->execute(1));
    }
}
