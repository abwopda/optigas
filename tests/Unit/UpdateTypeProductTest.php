<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\UpdateTypeProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTypeProductTest
 * @package App\Tests\Unit
 */
class UpdateTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductUpdated()
    {
        $useCase = new UpdateTypeProduct(new TypeProductRepository());

        $this->assertInstanceOf(TypeProduct::class, $useCase->execute(1));
    }
}
