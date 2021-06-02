<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UsePos;
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
        $useCase = new UsePos(new PosRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new PosRepository())->findOneById($i);

            $this->assertInstanceOf(Pos::class, $useCase->activate($entity, true));

            $this->assertInstanceOf(Pos::class, $useCase->activate($entity, false));
        }
    }
}
