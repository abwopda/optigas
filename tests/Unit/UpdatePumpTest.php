<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\UpdatePump;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdatePumpTest
 * @package App\Tests\Unit
 */
class UpdatePumpTest extends TestCase
{
    public function testSuccessfulPumpUpdated()
    {
        $useCase = new updatePump(new PumpRepository());

        for ($i = 11; $i <= 11; $i++) {
            $entity = (new PumpRepository())
                ->findOneById($i)
                ->setName("PUMP0" . $i)
            ;
            $this->assertInstanceOf(Pump::class, $useCase->execute($entity));
        }
    }
}
