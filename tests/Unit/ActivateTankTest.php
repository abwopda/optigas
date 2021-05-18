<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\ActivateTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateTankTest
 * @package App\Tests\Unit
 */
class ActivateTankTest extends TestCase
{
    public function testSuccessfulTankActivated()
    {
        $useCase = new activateTank(new TankRepository());
        $tank = $useCase->execute(1, 1);

        //var_export($tank);

        $this->assertInstanceOf(Tank::class, $tank);

        $tank = $useCase->execute(1, 0);

        //var_export($tank);

        $this->assertInstanceOf(Tank::class, $tank);
    }
}
