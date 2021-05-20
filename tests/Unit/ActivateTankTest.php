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
        for ($i = 1; $i <= 3; $i++) {
            $entity = (new TankRepository())->findOneById($i);

            $this->assertInstanceOf(Tank::class, $useCase->execute($entity, 1));

            $this->assertInstanceOf(Tank::class, $useCase->execute($entity, 0));
        }
    }
}
