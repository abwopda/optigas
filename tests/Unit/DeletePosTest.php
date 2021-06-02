<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UsePos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class DeletePosTest
 * @package App\Tests\Unit
 */
class DeletePosTest extends TestCase
{
    public function testSuccessfulPosDeleted()
    {
        $useCase = new UsePos(new PosRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new PosRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
