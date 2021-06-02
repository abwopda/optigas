<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UseTank;
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
        $useCase = new UseTank(new TankRepository());

        for ($i = 4; $i <= 4; $i++) {
            $entity = (new TankRepository())
                ->findOneById($i)
                ->setName("TANK0" . $i)
            ;
            $this->assertInstanceOf(Tank::class, $useCase->update($entity));
        }
    }
}
