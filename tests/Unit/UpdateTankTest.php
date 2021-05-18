<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UpdateTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTankTest
 * @package App\Tests\Unit
 */
class UpdateTankTest extends TestCase
{
    public function testSuccessfulTankUpdated()
    {
        $useCase = new updateTank(new TankRepository());

        $this->assertInstanceOf(Tank::class, $useCase->execute(1));
    }
}
