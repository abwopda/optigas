<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\IndexPump;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexPumpTest
 * @package App\Tests\Unit
 */
class IndexPumpTest extends TestCase
{
    public function testSuccessfulPumpIndexed()
    {
        $useCase = new IndexPump(new PumpRepository());
        $this->assertContainsOnlyInstancesOf(Pump::class, $useCase->execute());
    }
}
