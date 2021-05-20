<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\IndexTypeProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexTypeProductTest
 * @package App\Tests\Unit
 */
class IndexTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductIndexed()
    {
        $useCase = new IndexTypeProduct(new TypeProductRepository());
        $this->assertContainsOnlyInstancesOf(TypeProduct::class, $useCase->execute());
    }
}
