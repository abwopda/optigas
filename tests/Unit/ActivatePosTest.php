<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\ActivatePos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivatePosTest
 * @package App\Tests\Unit
 */
class ActivatePosTest extends TestCase
{
    public function testSuccessfulPosActivated()
    {
        $useCase = new activatePos(new PosRepository());
        for ($i = 1; $i <= 3; $i++) {
            $entity = (new PosRepository())->findOneById($i);

            $this->assertInstanceOf(Pos::class, $useCase->execute($entity, 1));

            $this->assertInstanceOf(Pos::class, $useCase->execute($entity, 0));
        }
    }
}
