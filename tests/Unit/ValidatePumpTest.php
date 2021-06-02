<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\UsePump;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatePumpTest
 * @package App\Tests\Unit
 */
class ValidatePumpTest extends TestCase
{
    public function testSuccessfulPumpValidated()
    {
        $useCase = new UsePump(new PumpRepository());
        for ($i = 11; $i <= 11; $i++) {
            $entity = (new PumpRepository())->findOneById($i);

            $this->assertInstanceOf(Pump::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(Pump::class, $useCase->validate($entity, false));
        }
    }
}
