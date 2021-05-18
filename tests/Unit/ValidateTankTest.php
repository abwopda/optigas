<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\ValidateTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateTankTest
 * @package App\Tests\Unit
 */
class ValidateTankTest extends TestCase
{
    public function testSuccessfulTankValidated()
    {
        $useCase = new validateTank(new TankRepository());
        $tank = $useCase->execute(1, 1);

        //var_export($tank);

        $this->assertInstanceOf(Tank::class, $tank);

        $tank = $useCase->execute(1, 0);

        //var_export($tank);

        $this->assertInstanceOf(Tank::class, $tank);
    }
}
