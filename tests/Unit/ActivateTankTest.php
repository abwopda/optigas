<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UseTank;
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
        $useCase = new UseTank(new TankRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TankRepository())->findOneById($i);

            $this->assertInstanceOf(Tank::class, $useCase->activate($entity, true));

            $this->assertInstanceOf(Tank::class, $useCase->activate($entity, false));
        }
    }
}
