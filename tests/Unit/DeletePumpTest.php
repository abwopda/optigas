<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\UsePump;
use PHPUnit\Framework\TestCase;

/**
 * Class DeletePumpTest
 * @package App\Tests\Unit
 */
class DeletePumpTest extends TestCase
{
    public function testSuccessfulPumpDeleted()
    {
        $useCase = new UsePump(new PumpRepository());
        for ($i = 11; $i <= 11; $i++) {
            $entity = (new PumpRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
