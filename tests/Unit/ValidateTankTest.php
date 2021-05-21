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
        for ($i = 1; $i <= 3; $i++) {
            $entity = (new TankRepository())->findOneById($i);

            $this->assertInstanceOf(Tank::class, $useCase->execute($entity, true));

            $this->assertInstanceOf(Tank::class, $useCase->execute($entity, false));
        }
    }
}
