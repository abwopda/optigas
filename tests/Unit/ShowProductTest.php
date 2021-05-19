<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\showProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowProductTest
 * @package App\Tests\Unit
 */
class ShowProductTest extends TestCase
{
    public function testSuccessfulProductShowed()
    {
        $useCase = new showProduct(new ProductRepository());

        $this->assertInstanceOf(Product::class, $useCase->execute(1));
    }

    /**
     * @dataProvider provideBadProduct
     * @param int $product
     */
    public function testBadProduct(int $product)
    {
        $useCase = new showProduct(new ProductRepository());

        $this->assertNull($useCase->execute($product));
    }

    /**
     * @return \Generator
     */
    public function provideBadProduct(): \Generator
    {
        yield [
            20
        ];
    }
}
