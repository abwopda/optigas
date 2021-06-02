<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\UsePump;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivatePumpTest
 * @package App\Tests\Unit
 */
class ActivatePumpTest extends TestCase
{
    public function testSuccessfulPumpActivated()
    {
        $useCase = new UsePump(new PumpRepository());
        for ($i = 11; $i <= 11; $i++) {
            $entity = (new PumpRepository())->findOneById($i);

            $this->assertInstanceOf(Pump::class, $useCase->activate($entity, true));

            $this->assertInstanceOf(Pump::class, $useCase->activate($entity, false));
        }
    }
}
