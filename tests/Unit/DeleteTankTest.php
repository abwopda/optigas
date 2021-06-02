<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UseTank;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteTankTest
 * @package App\Tests\Unit
 */
class DeleteTankTest extends TestCase
{
    public function testSuccessfulTankDeleted()
    {
        $useCase = new UseTank(new TankRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TankRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
