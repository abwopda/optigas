<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\IndexPos;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexPosTest
 * @package App\Tests\Unit
 */
class IndexPosTest extends TestCase
{
    public function testSuccessfulPosIndexed()
    {
        $useCase = new IndexPos(new PosRepository());
        $this->assertContainsOnlyInstancesOf(Pos::class, $useCase->execute());
    }
}
