<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\ValidatePump;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatePumpTest
 * @package App\Tests\Unit
 */
class ValidatePumpTest extends TestCase
{
    public function testSuccessfulPumpValidated()
    {
        $useCase = new validatePump(new PumpRepository());
        for ($i = 1; $i <= 11; $i++) {
            $entity = (new PumpRepository())->findOneById($i);

            $this->assertInstanceOf(Pump::class, $useCase->execute($entity, true));

            $this->assertInstanceOf(Pump::class, $useCase->execute($entity, false));
        }
    }
}
