<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UsePos;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdatePosTest
 * @package App\Tests\Unit
 */
class UpdatePosTest extends TestCase
{
    public function testSuccessfulPosUpdated()
    {
        $useCase = new UsePos(new PosRepository());
        for ($i = 3; $i <= 3; $i++) {
            $pos = (new PosRepository())
                ->findOneById($i)
                ->setName("TAWAAL OIL " . $i)
            ;

            $this->assertInstanceOf(Pos::class, $useCase->update($pos));
        }
    }
}
