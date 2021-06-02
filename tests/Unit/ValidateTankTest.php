<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UseTank;
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
        $useCase = new UseTank(new TankRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TankRepository())->findOneById($i);

            $this->assertInstanceOf(Tank::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(Tank::class, $useCase->validate($entity, false));
        }
    }
}
