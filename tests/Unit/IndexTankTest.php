<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\IndexTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexTankTest
 * @package App\Tests\Unit
 */
class IndexTankTest extends TestCase
{
    public function testSuccessfulTankIndexed()
    {
        $useCase = new IndexTank(new TankRepository());
        $this->assertContainsOnlyInstancesOf(Tank::class, $useCase->execute());
    }
}
