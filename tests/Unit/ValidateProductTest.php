<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\ValidateProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateProductTest
 * @package App\Tests\Unit
 */
class ValidateProductTest extends TestCase
{
    public function testSuccessfulProductValidated()
    {
        $useCase = new validateProduct(new ProductRepository());
        $tank = $useCase->execute(1, 1);

        //var_export($tank);

        $this->assertInstanceOf(Product::class, $tank);

        $tank = $useCase->execute(1, 0);

        //var_export($tank);

        $this->assertInstanceOf(Product::class, $tank);
    }
}
