<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UseTank;
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
        $useCase = new UseTank(new TankRepository());
        $this->assertContainsOnlyInstancesOf(Tank::class, $useCase->findAll());
    }
}
