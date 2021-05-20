<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\IndexProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexProductTest
 * @package App\Tests\Unit
 */
class IndexProductTest extends TestCase
{
    public function testSuccessfulProductIndexed()
    {
        $useCase = new IndexProduct(new ProductRepository());
        $this->assertContainsOnlyInstancesOf(Product::class, $useCase->execute());
    }
}
