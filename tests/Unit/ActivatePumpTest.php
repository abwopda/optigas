<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\ActivatePump;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivatePumpTest
 * @package App\Tests\Unit
 */
class ActivatePumpTest extends TestCase
{
    public function testSuccessfulPumpActivated()
    {
        $useCase = new activatePump(new PumpRepository());
        for ($i = 1; $i <= 11; $i++) {
            $entity = (new PumpRepository())->findOneById($i);

            $this->assertInstanceOf(Pump::class, $useCase->execute($entity, 1));

            $this->assertInstanceOf(Pump::class, $useCase->execute($entity, 0));
        }
    }
}
