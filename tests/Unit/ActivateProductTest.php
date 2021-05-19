<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\ActivateProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateProductTest
 * @package App\Tests\Unit
 */
class ActivateProductTest extends TestCase
{
    public function testSuccessfulProductActivated()
    {
        $useCase = new activateProduct(new ProductRepository());
        $tank = $useCase->execute(1, 1);

        //var_export($tank);

        $this->assertInstanceOf(Product::class, $tank);

        $tank = $useCase->execute(1, 0);

        //var_export($tank);

        $this->assertInstanceOf(Product::class, $tank);
    }
}
